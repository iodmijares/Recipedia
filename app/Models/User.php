<?php

namespace App\Models;

use App\Notifications\EmailVerificationOtp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
        'email_verification_otp',
        'otp_expires_at',
        'otp_attempts',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_otp',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Generate and send OTP for email verification.
     */
    public function sendEmailVerificationOtp()
    {
        // Generate 6-digit OTP
        $otp = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Update user with OTP and expiration
        $this->update([
            'email_verification_otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
            'otp_attempts' => 0,
        ]);

        // Send OTP via email
        $this->notify(new EmailVerificationOtp($otp));

        Log::info('OTP sent for email verification', [
            'user_id' => $this->id,
            'email' => $this->email,
            'otp' => $otp, // Remove this in production for security
            'expires_at' => $this->otp_expires_at,
        ]);
    }

    /**
     * Verify the provided OTP.
     */
    public function verifyOtp($otp)
    {
        // Check if OTP exists and hasn't expired
        if (!$this->email_verification_otp || !$this->otp_expires_at) {
            return ['success' => false, 'message' => 'No OTP found. Please request a new one.'];
        }

        if ($this->otp_expires_at->isPast()) {
            return ['success' => false, 'message' => 'OTP has expired. Please request a new one.'];
        }

        if ($this->otp_attempts >= 5) {
            return ['success' => false, 'message' => 'Too many failed attempts. Please request a new OTP.'];
        }

        // Increment attempts
        $this->increment('otp_attempts');

        // Check if OTP matches
        if ($this->email_verification_otp !== $otp) {
            return ['success' => false, 'message' => 'Invalid OTP. Please try again.'];
        }

        // Mark email as verified and clear OTP data
        $this->update([
            'email_verified_at' => now(),
            'email_verification_otp' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
        ]);

        Log::info('Email verified successfully via OTP', [
            'user_id' => $this->id,
            'email' => $this->email,
        ]);

        return ['success' => true, 'message' => 'Email verified successfully!'];
    }

    /**
     * Check if user can request a new OTP (rate limiting).
     */
    public function canRequestNewOtp()
    {
        // Allow new OTP if no current OTP or if it's expired
        if (!$this->otp_expires_at || $this->otp_expires_at->isPast()) {
            return true;
        }

        // Allow new OTP if too many failed attempts
        if ($this->otp_attempts >= 5) {
            return true;
        }

        return false;
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user has verified their email address.
     */
    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Check if user is a moderator.
     */
    public function isModerator()
    {
        return $this->role === 'moderator';
    }

    /**
     * Check if user has admin or moderator privileges.
     */
    public function hasAdminAccess()
    {
        return in_array($this->role, ['admin', 'moderator']);
    }
    /**
     * Get the full URL for the profile picture or null if not set.
     */
        public function getProfilePictureUrlAttribute()
    {
            if (!$this->profile_picture) {
                return null;
            }

            // Try to generate a URL via the configured filesystem. If the
            // configured driver (e.g. 'cloudinary') is not available in this
            // runtime (missing package or misconfiguration), fall back to
            // returning the stored value directly which may already be a full URL.
            try {
                return Storage::url($this->profile_picture);
            } catch (\InvalidArgumentException $e) {
                // This exception is thrown when the disk/driver is not supported.
                Log::warning('Filesystem driver not available for profile picture: ' . $e->getMessage(), [
                    'user_id' => $this->id,
                    'profile_picture' => $this->profile_picture,
                ]);
                return $this->profile_picture;
            } catch (\Throwable $e) {
                // Unexpected errors (e.g. network or SDK issues) — log and return fallback.
                Log::error('Error generating profile picture URL: ' . $e->getMessage(), [
                    'user_id' => $this->id,
                ]);
                return $this->profile_picture;
            }
    }
}
