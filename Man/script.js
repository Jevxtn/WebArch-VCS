// API Configuration
const API_KEY = '0d312d7f-b4fb-42bd-9a80-72bfe4e41aff';
const API_BASE_URL = 'https://content.guardianapis.com';

// DOM Elements
const articlesContainer = document.getElementById('articlesContainer');
const loadingElement = document.getElementById('loading');
const errorElement = document.getElementById('errorMessage');
const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');
const navLinks = document.querySelectorAll('.nav a');

// State
let currentCategory = 'general';
let currentSearch = '';

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    // Set first nav link as active
    if (navLinks.length > 0) {
        navLinks[0].classList.add('active');
    }
    loadArticles('general');
    setupEventListeners();
});

// Setup Event Listeners
function setupEventListeners() {
    // Category Navigation
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const category = link.getAttribute('data-category');
            currentCategory = category;
            currentSearch = '';
            searchInput.value = '';
            
            // Update active link
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
            
            loadArticles(category);
        });
    });

    // Search Functionality
    searchBtn.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') performSearch();
    });
}

// Perform Search
function performSearch() {
    const query = searchInput.value.trim();
    if (!query) {
        showError('Please enter a search term');
        return;
    }
    currentSearch = query;
    currentCategory = 'general';
    navLinks.forEach(l => l.classList.remove('active'));
    loadArticles(null, query);
}

// Load Articles from API
async function loadArticles(category = null, searchQuery = null) {
    try {
        showLoading(true);
        hideError();

        let url;

        if (searchQuery) {
            url =
                `${API_BASE_URL}/search?q=${encodeURIComponent(searchQuery)}` +
                `&api-key=${API_KEY}` +
                `&show-fields=thumbnail,trailText`;
        } else {
            const categoryMap = {
                general: 'world',
                technology: 'technology',
                business: 'business',
                science: 'science',
                health: 'society',
            };

            const section = categoryMap[category] || 'world';

            url =
                `${API_BASE_URL}/search?section=${section}` +
                `&api-key=${API_KEY}` +
                `&show-fields=thumbnail,trailText`;
        }

        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(
                `API Error: ${response.status} ${response.statusText}`
            );
        }

        const data = await response.json();

        if (
            !data.response ||
            !data.response.results ||
            data.response.results.length === 0
        ) {
            displayNoArticles();
            showLoading(false);
            return;
        }

        displayArticles(data.response.results);

        showLoading(false);
    } catch (error) {
        console.error(error);

        showError(
            error.message ||
            'Failed to fetch articles.'
        );

        showLoading(false);
    }
}

// Display Articles
function displayArticles(articles) {
    articlesContainer.innerHTML = '';

    articles.forEach(article => {
        const card = createArticleCard(article);
        if (card) {
            articlesContainer.appendChild(card);
        }
    });

    // If no valid cards were created, show no articles message
    if (articlesContainer.children.length === 0) {
        displayNoArticles();
    }
}

// Create Article Card
function createArticleCard(article) {
    const card = document.createElement('article');
    card.className = 'article-card';

    const imageUrl =
        article.fields?.thumbnail ||
        'https://via.placeholder.com/400x200?text=No+Image';

    const title = truncateText(
        article.webTitle || 'Untitled',
        80
    );

    const description =
        truncateText(
            article.fields?.trailText ||
            'No description available.',
            150
        );

    const source =
        escapeHtml(article.sectionName || 'The Guardian');

    const articleUrl =
        article.webUrl || '#';

    let formattedDate = 'Unknown Date';

    try {
        formattedDate = new Date(
            article.webPublicationDate
        ).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    } catch (e) {}

    card.innerHTML = `
        <img
            class="article-image"
            src="${imageUrl}"
            alt="${title}"
            onerror="this.src='https://via.placeholder.com/400x200?text=No+Image';"
        >

        <div class="article-content">
            <div class="article-source">${source}</div>

            <h3 class="article-title">
                ${title}
            </h3>

            <p class="article-description">
                ${description}
            </p>

            <div class="article-meta">
                <span>${formattedDate}</span>
            </div>

            <a
                href="${articleUrl}"
                target="_blank"
                rel="noopener noreferrer"
                class="article-link"
            >
                Read More →
            </a>
        </div>
    `;

    return card;
}

// Utility: Escape HTML to prevent XSS
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Utility: Validate URL
function isValidUrl(string) {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
}

// Truncate Text
function truncateText(text, maxLength) {
    if (!text) return 'No text available';
    if (text.length > maxLength) {
        return text.substring(0, maxLength).trim() + '...';
    }
    return text;
}

// Display No Articles Message
function displayNoArticles() {
    articlesContainer.innerHTML = `
        <div class="no-articles" style="grid-column: 1 / -1;">
            <i class="fas fa-inbox"></i>
            <h3>No articles found</h3>
            <p>Try searching for different keywords or browse other categories</p>
        </div>
    `;
}

// Show/Hide Loading
function showLoading(show) {
    if (show) {
        loadingElement.classList.add('active');
    } else {
        loadingElement.classList.remove('active');
    }
}

// Show Error
function showError(message) {
    errorElement.textContent = message;
    errorElement.classList.add('active');
    
    // Auto-hide error after 5 seconds
    setTimeout(() => hideError(), 5000);
}

// Hide Error
function hideError() {
    errorElement.classList.remove('active');
}

// Refresh articles every 5 minutes
setInterval(() => {
    if (currentSearch) {
        loadArticles(null, currentSearch);
    } else {
        loadArticles(currentCategory);
    }
}, 300000);

// Intercept fetch to add API key and handle parameter mapping
(() => {
    const apiKey = "0d312d7f-b4fb-42bd-9a80-72bfe4e41aff";
    const originalFetch = window.fetch.bind(window);

    window.fetch = (input, init) => {
        if (typeof input === "string" && input.includes("newsdata.io/api/1/news")) {
            const url = new URL(input);

            url.searchParams.set("apikey", apiKey);

            for (const [key, value] of url.searchParams.entries()) {
                if (!value) {
                    url.searchParams.delete(key);
                }
            }

            const category = url.searchParams.get("category");
            if (category) {
                const normalizedCategory = category
                    .split(",")
                    .map((item) => item.trim() === "general" ? "top" : item.trim())
                    .filter(Boolean)
                    .join(",");
                url.searchParams.set("category", normalizedCategory);
            }

            if (url.searchParams.has("from")) {
                url.searchParams.set("from_date", url.searchParams.get("from"));
                url.searchParams.delete("from");
            }

            if (url.searchParams.has("to")) {
                url.searchParams.set("to_date", url.searchParams.get("to"));
                url.searchParams.delete("to");
            }

            url.searchParams.delete("sortBy");
            url.searchParams.delete("pageSize");

            input = url.toString();
        }

        return originalFetch(input, init);
    };
})();