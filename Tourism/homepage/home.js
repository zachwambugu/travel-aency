
//footer styling at the bottom
window.addEventListener('scroll', function() {
    const footer = document.getElementById('footer');
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        footer.style.display = 'block';
    } else {
        footer.style.display = 'none';
    }
});

//function saves the search query
function searchDestinations() {
    const location = document.getElementById('locationSearch').value;
    localStorage.setItem('searchLocation', location);
    window.location.href = '../search-results/results.html';
} 
