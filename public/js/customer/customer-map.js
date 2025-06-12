async function loadMap() {
    const {Map, InfoWindow} = await google.maps.importLibrary("maps");
    const {AdvancedMarkerElement, PinElement} = await google.maps.importLibrary(
        "marker",
    );
    const infoWindow = new InfoWindow();

    let centerLat = 0;
    let centerLng = 0;

    await fetch('http://152.42.255.40/customer-location')
        .then(response => response.json())
        .then(custLocation => {
            centerLat = parseFloat(custLocation.latitude);
            centerLng = parseFloat(custLocation.longitude)
        })
        .catch(error => console.error('Error fetching customer location! ', error));

    /* make the map focus directly into the customer location */
    const map = new Map(document.getElementById("map"), {
        zoom: 15,
        center: {lat: centerLat, lng: centerLng},
        mapId: "DEMO_MAP_ID",
    });

    /* Mark the position of the customer in the map */
    const pin = new PinElement({
        background: "#459ff8",
        borderColor: "#1b63b1",
        glyphColor: "#f7f7f8",
    });
    const customerMarker = new AdvancedMarkerElement({
        position: {lat: centerLat, lng: centerLng},
        map: map,
        title: `You`,
        content: pin.element,
    });
    customerMarker.addListener("click", ({domEvent, latLng}) => {
        const {target} = domEvent;

        infoWindow.close();
        infoWindow.setContent(customerMarker.title);
        infoWindow.open(customerMarker.map, customerMarker);
    });
    /* customer marker end */


    await fetch('http://152.42.255.40/geolocation-technicians')
        .then(response => response.json())
        .then(technicians => {
            console.log(technicians);
            technicians.forEach(technician => {
                const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
                    map: map,
                    content: buildContent(technician),
                    title: `${technician['fname']} ${technician['lname']}`,
                    position: {lat: parseFloat(technician['latitude']), lng: parseFloat(technician['longitude'])}
                });
                AdvancedMarkerElement.addEventListener("click", () => {
                    toggleHighlight(AdvancedMarkerElement, technician);
                });
            });

            function toggleHighlight(markerView, property) {
                if (markerView.content.classList.contains("highlight")) {
                    markerView.content.classList.remove("highlight");
                    markerView.zIndex = null;
                } else {
                    markerView.content.classList.add("highlight");
                    markerView.zIndex = 1;
                }
            }

            function buildContent(technician) {
                const content = document.createElement("div");

                content.classList.add("property");
                content.innerHTML = `
                    <div class="icon">
                        <i aria-hidden="true" class="fa fa-solid fa-wrench"></i> 
                        <span class="fa-sr-only">technician</span>
                    </div>
                    <div class="details">
                        <div class="name">${technician['fname']} ${technician['lname']}</div>
                        <div class="address">${technician['address']}</div>
                        <div class="features">
                            <button type="submit" class="btn-visit-profile-technician" onclick="locateTechnician(${technician['tech_id']})">Visit Profile</button>
                        </div>
                    </div>
                    `;
                return content;
            }

        })
        .catch(error => console.error('Error fetching technician geo co-ordinates: ', error));

    await fetch('http://152.42.255.40/geolocation-service-centres')
        .then(response => response.json())
        .then(serviceCentres => {
            console.log(serviceCentres);
            serviceCentres.forEach(serviceCentre => {
                const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
                    map: map,
                    content: buildContent(serviceCentre),
                    title: `${serviceCentre['name']}`,
                    position: {lat: parseFloat(serviceCentre['latitude']), lng: parseFloat(serviceCentre['longitude'])}
                });
                AdvancedMarkerElement.addEventListener("click", () => {
                    toggleHighlight(AdvancedMarkerElement, serviceCentre);
                });
            });

            function toggleHighlight(markerView, property) {
                if (markerView.content.classList.contains("highlight")) {
                    markerView.content.classList.remove("highlight");
                    markerView.zIndex = null;
                } else {
                    markerView.content.classList.add("highlight");
                    markerView.zIndex = 1;
                }
            }

            function buildContent(serviceCentre) {
                const content = document.createElement("div");

                content.classList.add("property");
                content.innerHTML = `
                    <div class="icon">
                         <i class="fa-solid fa-warehouse"></i> 
                        <span class="fa-sr-only">serviceCentre</span>
                    </div>
                    <div class="details">
                        <div class="name">${serviceCentre['name']}</div>
                        <div class="address">${serviceCentre['address']}</div>
                        <div class="features">
                            <button type="submit" class="btn-visit-profile-centre" onclick="locateServiceCentre(${serviceCentre['ser_cen_id']})">Visit Profile</button>
                        </div>
                    </div>
                    `;
                return content;
            }

        })
        .catch(error => console.error('Error fetching service centres geo co-ordinates: ', error));
}

function locateTechnician(techId) {
    window.location.href = `/technician-profile/${techId}`;
}

function locateServiceCentre(serviceCentreId) {
    window.location.href = `/service-center-profile/${serviceCentreId}`;
}

window.onload = loadMap;
