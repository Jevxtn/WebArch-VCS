// ========== Dashboard Handler ==========

let currentFilter = 'month';
let categoryChart = null;
let distributionChart = null;

document.addEventListener('DOMContentLoaded', () => {
    checkAuth();
});

async function checkAuth() {
    // Verify the PHP session is valid on the server.
    try {
        const res  = await fetch('backend/check_session.php');
        const data = await res.json();
        if (!data.success) {
            window.location.href = 'login.html';
            return;
        }

        // Show the authenticated user name in the top-right header.
        setDashboardUserName(data);
    } catch {
        window.location.href = 'login.html';
        return;
    }
    // Session is valid — boot the rest of the dashboard
    initDashboard();
    setupEventListeners();
    loadDashboardData();
}

function setDashboardUserName(sessionData) {
    const nameEl = document.getElementById('userName');
    if (!nameEl || !sessionData) return;

    const displayName = (sessionData.full_name || sessionData.username || sessionData.email || 'User').trim();
    nameEl.textContent = displayName;
}

function loadDashboardData() {
    loadStatistics(currentFilter);
    loadExpenses();
    loadInvoices();
}

function initDashboard() {
    // Set current date
    document.getElementById('date').valueAsDate = new Date();
    document.getElementById('invoiceDate').valueAsDate = new Date();

    // Load categories
    loadCategories();

    // Load initial data
    loadExpenses();
    loadStatistics();
    loadInvoices();
}

function setupEventListeners() {
    // Navigation
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', handleNavClick);
    });

    // Sidebar toggle
    document.getElementById('menuToggle').addEventListener('click', toggleSidebar);

    // Logout
    document.getElementById('logoutBtn').addEventListener('click', handleLogout);

    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', handleFilterClick);
    });

    // Add expense form
    document.getElementById('addExpenseForm').addEventListener('submit', handleAddExpense);

    // Upload invoice
    document.getElementById('uploadInvoiceForm').addEventListener('submit', handleUploadInvoice);

    // Upload area drag and drop
    const uploadArea = document.getElementById('uploadArea');
    uploadArea.addEventListener('dragover', handleDragOver);
    uploadArea.addEventListener('drop', handleDrop);
    uploadArea.addEventListener('click', () => {
        document.getElementById('invoiceFile').click();
    });

    document.getElementById('invoiceFile').addEventListener('change', handleFileSelect);
}

// Navigation Handlers
function handleNavClick(e) {
    e.preventDefault();
    const page = this.getAttribute('data-page');
    
    // Remove active class from all links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });
    this.classList.add('active');

    // Hide all pages
    document.querySelectorAll('.page').forEach(page => {
        page.classList.remove('active');
    });

    // Show selected page
    document.getElementById(page).classList.add('active');

    // Close sidebar on mobile
    closeSidebar();

    // Load data for specific page
    if (page === 'expenses') {
        loadExpenses('all');
    } else if (page === 'analytics') {
        setTimeout(() => {
            initAnalytics();
        }, 100);
    }
}

function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('active');
}

// Filter Handlers
function handleFilterClick(e) {
    const btn = e.target.closest('.filter-btn');
    if (!btn) return;
    const filter = btn.getAttribute('data-filter');
    currentFilter = filter;

    // Update active button
    btn.parentElement.querySelectorAll('.filter-btn').forEach(b => {
        b.classList.remove('active');
    });
    btn.classList.add('active');

    // Load filtered data
    const currentPage = document.querySelector('.page.active');
    if (currentPage.id === 'dashboard') {
        loadStatistics(filter);
    } else if (currentPage.id === 'expenses') {
        loadExpenses(filter);
    }
}

// Logout Handler
async function handleLogout() {
    try {
        await fetch('backend/logout.php', {
            method: 'POST'
        });
        window.location.href = 'login.html';
    } catch (error) {
        console.error('Logout error:', error);
    }
}

// Load Categories
async function loadCategories() {
    try {
        const response = await fetch('backend/get_categories.php');
        const data = await response.json();

        if (data.success) {
            const categorySelect = document.getElementById('category');
            categorySelect.innerHTML = '<option value="">Select a category</option>';

            data.categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                option.style.borderLeft = `4px solid ${category.color}`;
                categorySelect.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error loading categories:', error);
    }
}

// Load Statistics
async function loadStatistics(filter = 'month') {
    try {
        const response = await fetch(`backend/get_statistics.php?filter=${filter}`);
        const data = await response.json();

        if (data.success) {
            document.getElementById('totalSpent').textContent = `$${data.total.toFixed(2)}`;
            document.getElementById('dailyAverage').textContent = `$${data.daily_average.toFixed(2)}`;
            document.getElementById('transactionCount').textContent = data.count ?? data.recent.length;

            // Update recent expenses
            updateRecentExpenses(data.recent);

            // Update category chart
            updateCategoryChart(data.by_category);
        }
    } catch (error) {
        console.error('Error loading statistics:', error);
    }
}

// Load Expenses
async function loadExpenses(filter = 'all') {
    try {
        const response = await fetch(`backend/get_expenses.php?filter=${filter}`);
        const data = await response.json();

        if (data.success) {
            const expensesList = document.getElementById('expensesList');
            
            if (data.expenses.length === 0) {
                expensesList.innerHTML = '<p class="empty-state">No expenses found</p>';
                return;
            }

            expensesList.innerHTML = '';
            data.expenses.forEach(expense => {
                const expenseElement = createExpenseElement(expense);
                expensesList.appendChild(expenseElement);
            });
        }
    } catch (error) {
        console.error('Error loading expenses:', error);
    }
}

// Create Expense Element
function createExpenseElement(expense) {
    const div = document.createElement('div');
    div.className = 'expense-item';
    const date = new Date(expense.date).toLocaleDateString();
    
    div.innerHTML = `
        <div class="expense-info">
            <div class="expense-category" style="background-color: ${expense.color}">
                <i class="fas fa-${expense.icon || 'tag'}"></i>
            </div>
            <div class="expense-details">
                <div class="expense-description">${expense.description}</div>
                <div class="expense-meta">${expense.category_name} • ${date} • ${expense.payment_method}</div>
            </div>
        </div>
        <div class="expense-actions">
            <div class="expense-amount">-$${parseFloat(expense.amount).toFixed(2)}</div>
            <button class="btn-delete" onclick="deleteExpense(${expense.id})" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    
    return div;
}

// Update Recent Expenses
function updateRecentExpenses(expenses) {
    const recentList = document.getElementById('recentList');
    
    if (expenses.length === 0) {
        recentList.innerHTML = '<p class="empty-state">No expenses yet</p>';
        return;
    }

    recentList.innerHTML = '';
    expenses.forEach(expense => {
        const li = document.createElement('div');
        li.style.display = 'flex';
        li.style.justifyContent = 'space-between';
        li.style.padding = '10px 0';
        li.style.borderBottom = '1px solid var(--border-color)';
        li.innerHTML = `
            <span>${expense.description} • ${expense.category_name}</span>
            <span style="color: var(--danger-color); font-weight: 600;">-$${parseFloat(expense.amount).toFixed(2)}</span>
        `;
        recentList.appendChild(li);
    });
}

// Update Category Chart
function updateCategoryChart(categories) {
    const ctx = document.getElementById('categoryChart');
    if (!ctx) return;

    const labels = categories.map(c => c.name);
    const data = categories.map(c => parseFloat(c.total));
    const colors = categories.map(c => c.color);

    if (categoryChart) {
        categoryChart.data.labels = labels;
        categoryChart.data.datasets[0].data = data;
        categoryChart.data.datasets[0].backgroundColor = colors;
        categoryChart.update();
    } else {
        categoryChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                    borderColor: 'var(--bg-secondary)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '58%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'var(--text-primary)',
                            padding: 15,
                            font: { size: 12 }
                        }
                    }
                }
            }
        });
    }
}

// Add Expense Handler
async function handleAddExpense(e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch('backend/add_expense.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showToast('Expense added successfully!', 'success');
            document.getElementById('addExpenseForm').reset();
            document.getElementById('date').valueAsDate = new Date();
            
            // Reload data
            loadExpenses();
            loadStatistics(currentFilter);
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error adding expense', 'error');
    }
}

// Delete Expense Handler
async function deleteExpense(expenseId) {
    if (!confirm('Are you sure you want to delete this expense?')) return;

    const formData = new FormData();
    formData.append('expense_id', expenseId);

    try {
        const response = await fetch('backend/delete_expense.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showToast('Expense deleted successfully!', 'success');
            loadExpenses();
            loadStatistics(currentFilter);
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error deleting expense', 'error');
    }
}

// Drag and Drop Handlers
function handleDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    this.style.borderColor = 'var(--secondary-color)';
}

function handleDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    const files = e.dataTransfer.files;
    document.getElementById('invoiceFile').files = files;
    handleFileSelect.call({ target: { files: files } });
}

function handleFileSelect(e) {
    const file = e.target.files[0];
    if (file) {
        showToast(`File selected: ${file.name}`, 'success');
    }
}

// Upload Invoice Handler
async function handleUploadInvoice(e) {
    e.preventDefault();

    const file = document.getElementById('invoiceFile').files[0];
    if (!file) {
        showToast('Please select a file', 'error');
        return;
    }

    const formData = new FormData(this);
    formData.append('invoice_file', file);

    try {
        const response = await fetch('backend/upload_invoice.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showToast('Invoice uploaded successfully!', 'success');
            document.getElementById('uploadInvoiceForm').reset();
            document.getElementById('invoiceFile').value = '';
            document.getElementById('invoiceDate').valueAsDate = new Date();
            loadInvoices();
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error uploading invoice', 'error');
    }
}

// Load Invoices
async function loadInvoices() {
    try {
        const response = await fetch('backend/get_invoices.php');
        const data = await response.json();

        if (data.success) {
            const invoicesList = document.getElementById('invoicesList');
            
            if (data.invoices.length === 0) {
                invoicesList.innerHTML = '<p class="empty-state">No invoices uploaded</p>';
                return;
            }

            invoicesList.innerHTML = '';
            data.invoices.forEach(invoice => {
                const div = document.createElement('div');
                div.className = 'invoice-item';
                const uploadDate = new Date(invoice.uploaded_at).toLocaleDateString();
                
                div.innerHTML = `
                    <div class="invoice-info">
                        <div class="invoice-vendor">${invoice.vendor_name || 'Unknown Vendor'}</div>
                        <div class="invoice-meta">
                            Invoice #${invoice.invoice_number || 'N/A'} • Uploaded ${uploadDate} • $${parseFloat(invoice.total_amount || 0).toFixed(2)}
                        </div>
                    </div>
                    <button class="invoice-download" onclick="downloadInvoice('${invoice.file_path}', '${invoice.file_name}')">
                        <i class="fas fa-download"></i>
                    </button>
                `;
                invoicesList.appendChild(div);
            });
        }
    } catch (error) {
        console.error('Error loading invoices:', error);
    }
}

// Download Invoice
function downloadInvoice(filePath, fileName) {
    const link = document.createElement('a');
    link.href = filePath;
    link.download = fileName;
    link.click();
}

// Initialize Analytics
async function initAnalytics() {
    try {
        const response = await fetch(`backend/get_statistics.php?filter=${currentFilter}`);
        const data = await response.json();

        if (data.success) {
            updateDistributionChart(data.by_category);
            updateCategoryBreakdown(data.by_category);
        }
    } catch (error) {
        console.error('Error loading analytics:', error);
    }
}

// Update Distribution Chart
function updateDistributionChart(categories) {
    const ctx = document.getElementById('distributionChart');
    if (!ctx) return;

    const labels = categories.map(c => c.name);
    const data = categories.map(c => parseFloat(c.total));
    const colors = categories.map(c => c.color);

    if (distributionChart) {
        distributionChart.destroy();
    }

    distributionChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Amount Spent',
                data: data,
                backgroundColor: colors,
                borderColor: colors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            layout: {
                padding: {
                    right: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'var(--text-secondary)',
                        callback: function(value) {
                            return '$' + value;
                        }
                    },
                    grid: {
                        color: 'rgba(148, 163, 184, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        color: 'var(--text-secondary)'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Update Category Breakdown
function updateCategoryBreakdown(categories) {
    const breakdown = document.getElementById('categoryBreakdown');
    if (!breakdown) return;

    breakdown.innerHTML = '';
    const total = categories.reduce((sum, c) => sum + parseFloat(c.total), 0);

    categories.forEach(category => {
        const amount = parseFloat(category.total) || 0;
        const percentage = total > 0 ? ((amount / total) * 100).toFixed(1) : '0.0';
        const div = document.createElement('div');
        div.className = 'breakdown-item';
        
        div.innerHTML = `
            <div class="breakdown-head">
                <span class="name">${category.name}</span>
                <span class="amount">$${amount.toFixed(2)}</span>
            </div>
            <div class="breakdown-track">
                <div class="breakdown-fill" style="background-color: ${category.color}; width: ${percentage}%;"></div>
            </div>
            <div class="breakdown-percent">${percentage}%</div>
        `;
        breakdown.appendChild(div);
    });
}

// Toast Notification
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    toast.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
