<?php

namespace App\Helpers;

class Flash
{
    /**
     * Flash a success message.
     */
    public static function success($message, $title = 'Success!')
    {
        session()->flash('success', $message);
        session()->flash('success_title', $title);
        return redirect()->back();
    }

    /**
     * Flash an error message.
     */
    public static function error($message, $title = 'Error!')
    {
        session()->flash('error', $message);
        session()->flash('error_title', $title);
        return redirect()->back();
    }

    /**
     * Flash a warning message.
     */
    public static function warning($message, $title = 'Warning!')
    {
        session()->flash('warning', $message);
        session()->flash('warning_title', $title);
        return redirect()->back();
    }

    /**
     * Flash an info message.
     */
    public static function info($message, $title = 'Information')
    {
        session()->flash('info', $message);
        session()->flash('info_title', $title);
        return redirect()->back();
    }

    /**
     * Flash a toast message.
     */
    public static function toast($message, $type = 'success')
    {
        session()->flash("toast_{$type}", $message);
        return redirect()->back();
    }

    /**
     * Flash a toast success message.
     */
    public static function toastSuccess($message)
    {
        return self::toast($message, 'success');
    }

    /**
     * Flash a toast error message.
     */
    public static function toastError($message)
    {
        return self::toast($message, 'error');
    }

    /**
     * Flash a toast info message.
     */
    public static function toastInfo($message)
    {
        return self::toast($message, 'info');
    }

    /**
     * Flash a toast warning message.
     */
    public static function toastWarning($message)
    {
        return self::toast($message, 'warning');
    }
}