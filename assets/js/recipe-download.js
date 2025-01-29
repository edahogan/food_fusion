async function downloadRecipe(recipeId, title) {
    try {
        // Show loading state
        const loadingToast = showToast('Preparing download...');
        
        // Fetch the recipe page content
        const response = await fetch(`recipe.php?id=${recipeId}&screenshot=true`);
        const html = await response.text();
        
        // Create a temporary container
        const container = document.createElement('div');
        container.style.position = 'absolute';
        container.style.left = '-9999px';
        container.style.width = '1200px'; // Fixed width for consistent screenshots
        container.innerHTML = html;
        document.body.appendChild(container);
        
        // Find the recipe content (excluding header and footer)
        const recipeContent = container.querySelector('.container.mx-auto.px-4.py-8');
        
        if (!recipeContent) {
            throw new Error('Recipe content not found');
        }
        
        // Take screenshot
        const canvas = await html2canvas(recipeContent, {
            scale: 1,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff',
            logging: false
        });
        
        // Convert to image and download
        const image = canvas.toDataURL('image/png');
        const link = document.createElement('a');
        link.download = `${title.toLowerCase().replace(/\s+/g, '-')}-recipe.png`;
        link.href = image;
        link.click();
        
        // Cleanup
        document.body.removeChild(container);
        hideToast(loadingToast);
        showToast('Recipe downloaded successfully!', 'success');
        
    } catch (error) {
        console.error('Error downloading recipe:', error);
        showToast('Failed to download recipe. Please try again.', 'error');
    }
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
        type === 'error' ? 'bg-red-500' : 
        type === 'success' ? 'bg-green-500' : 
        'bg-blue-500'
    } text-white`;
    toast.textContent = message;
    document.body.appendChild(toast);
    return toast;
}

function hideToast(toast) {
    if (toast && toast.parentElement) {
        toast.parentElement.removeChild(toast);
    }
} 