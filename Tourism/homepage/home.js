
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


// fetch and display the sample destinations and handle the click event to show all destinations within the price range
document.addEventListener('DOMContentLoaded', () => {
    loadSampleDestinations();
});

function loadSampleDestinations() {
    const ranges = [
        { min: 1000, max: 2000, elementId: 'range1-destination' },
        { min: 2001, max: 5000, elementId: 'range2-destination' },
        { min: 5001, max: 20000, elementId: 'range3-destination' }
    ];

    ranges.forEach(range => {
        fetch(`../get_sample_destination.php?min_price=${range.min}&max_price=${range.max}`)
            .then(response => response.json())
            .then(destination => {
                if (destination.error) {
                    console.error(destination.error);
                } else {
                    const container = document.getElementById(range.elementId);
                    container.innerHTML = `
                        <img src="../${destination.image_path}" alt="${destination.name}">
                        <h2>${destination.name}</h2>
                        <p>${destination.description}</p>
                        <p><strong>Location:</strong> ${destination.location}</p>
                    `;
                }
            })
            .catch(error => console.error('Error fetching sample destination:', error));
    });
}


function showDestinationsInRange(min_price, max_price) {
        fetch(`../get_destinations_in_range.php?min_price=${min_price}&max_price=${max_price}`)
            .then(response => response.json())
            .then(destinations => {
                console.log(destinations); // Debug log
                if (destinations.error) {
                    console.error(destinations.error);
                } else {
                    // Determine the target container based on the price range
                    let containerId;
                    if (min_price === 1000 && max_price === 2000) {
                        containerId = 'range1-destination';
                    } else if (min_price === 2001 && max_price === 5000) {
                        containerId = 'range2-destination';
                    } else if (min_price === 5001 && max_price === 20000) {
                        containerId = 'range3-destination';
                    }

                    const container = document.getElementById(containerId);
                    container.innerHTML = '';

                    destinations.forEach(destination => {
                        const div = document.createElement('div');
                        div.className = 'card';
                        div.innerHTML = `
                            <img src="../${destination.image_path}" alt="${destination.name}">
                            <h2>${destination.name}</h2>
                            <p>${destination.description}</p>
                            <p><strong>Location:</strong> ${destination.location}</p>
                            <p><strong>Distance from Nairobi:</strong> ${destination.distance} km</p>
                            <p><strong>Nearest Towns:</strong> ${destination.towns}</p>
                            <p><strong>Price:</strong> ${destination.cost}</p>
                            <button class="learnmore" onclick="showDestinationDetails(${destination.destination_id})">Learn more</button>
                        `;
                        container.appendChild(div);
                    });
                }
            })
            .catch(error => console.error('Error fetching destinations in range:', error));
    }

    // Function to show destination details in a modal
    function showDestinationDetails(destinationId) {
        fetch(`../get_destination_details.php?id=${destinationId}`)
            .then(response => response.json())
            .then(destination => {
                if (destination.error) {
                    console.error(destination.error);
                } else {
                    const modalContent = `
                        <h2>${destination.name}</h2>
                        <p><strong>Description:</strong> ${destination.description}</p>
                        <p><strong>Location:</strong> ${destination.location}</p>
                        <p><strong>Distance from Nairobi:</strong> ${destination.distance} km</p>
                        <p><strong>Nearest Towns:</strong> ${destination.towns}</p>
                        <p><strong>Price:</strong> ${destination.cost}</p>
                    `;
                    // Assuming you have a modal element with id "destination-modal"
                    document.getElementById('destination-modal-content').innerHTML = modalContent;
                    document.getElementById('destination-modal').style.display = 'block';
                }
            })
            .catch(error => console.error('Error fetching destination details:', error));
    }


