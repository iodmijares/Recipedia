import './bootstrap';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
import '../js/ajax.bundle.min.js';

// Dynamic AJAX recipe grid for browse page
if (document.getElementById('recipe-grid')) {
    function renderRecipes(recipes) {
        const grid = document.getElementById('recipe-grid');
        grid.innerHTML = '';
        recipes.forEach(recipe => {
            const card = document.createElement('div');
            card.className = 'bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden h-full flex flex-col';
            card.innerHTML = `
                <a href="/recipes/${recipe.id}" class="block group">
                    <div class="relative h-64 overflow-hidden shrink-0">
                        ${recipe.recipe_images && recipe.recipe_images.length > 0 ?
                            `<img src="/storage/${recipe.recipe_images[0]}" alt="${recipe.recipe_name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">`
                            : `<div class="w-full h-full bg-gradient-to-br from-orange-200 via-pink-200 to-purple-300 flex items-center justify-center"><svg class="w-20 h-20 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>`}
                        ${recipe.prep_time ? `<div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-gray-800 text-sm px-3 py-1 rounded-full font-medium shadow-lg"><svg class="w-4 h-4 inline mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>${recipe.prep_time}</div>` : ''}
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent h-24"></div>
                        <div class="absolute bottom-4 left-4 right-4"><h3 class="text-xl font-bold text-white leading-tight line-clamp-2 drop-shadow-md">${recipe.recipe_name}</h3></div>
                    </div>
                </a>
            `;
            grid.appendChild(card);
        });
    }
    function fetchRecipes(page = 1) {
        ajax({
            url: `/recipes-ajax?page=${page}`,
            method: 'GET',
            responseType: 'json',
            success: function(data) {
                renderRecipes(data.recipes);
                // Optionally update pagination controls here
            },
            error: function(err) {
                window.dispatchEvent(new CustomEvent('show-toast', { detail: { type: 'error', message: 'Failed to load recipes.' } }));
            }
        });
    }
    // Initial load
    fetchRecipes();
    // Example: add event listeners for pagination buttons if present
    // document.getElementById('next-page-btn').addEventListener('click', () => fetchRecipes(currentPage + 1));
}
