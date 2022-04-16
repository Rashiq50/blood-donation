@extends('layouts.app')


@section('content')
    <div class="card p-2">
        <div class="card-body">
            <form id="info">
                <div class="d-flex">
                    <input placeholder="Search" onchange="getDonors()" id="search" type="text" class="form-control"/>

                    <input id="area" placeholder="Area" onchange="addArea()" type="text" class="form-control mx-2" />
                    
                    <select onchange="getDonors()" id="group" name="blood_group"
                        class="form-control @error('blood_group') is-invalid @enderror mx-1">
                        <option value="none"> Select blood group </option>
                        <option value="a+"> A+ (A positive) </option>
                        <option value="a-"> A- (A negative)</option>
                        <option value="b+"> B+ (B positive)</option>
                        <option value="b-"> B- (B negative)</option>
                        <option value="o+"> O+ (O positive)</option>
                        <option value="o-"> O- (O negative)</option>
                        <option value="ab+"> AB+ (AB positive)</option>
                        <option value="ab-"> AB- (AB negative)</option>
                    </select>

                    <button type="button" onclick="getDonors()" class="btn btn-sm btn-success mx-2">Search</button>
                </div>
            </form>

            <hr />
            <div id="locations" class="d-flex flew-wrap">

            </div>
            <div id="donors">

            </div>

        </div>
    </div>

    <script>
        const state = {
            search: "",
            group:"",
            areas:[]
        }
        const apiData = @json($donors);
        let donors = apiData.data;

        function formSubmit() {
            document.getElementById("info").submit();
        }

        function addChips() {
            const parent = document.getElementById('locations');
            removeAllChildNodes(parent);
            for (let i = 0; i < state.areas.length; i++) {
                const area = state.areas[i];
                const chip = document.createElement("div");
                chip.style = "border-radius: 25px";
                chip.className = "px-2 py-1 border shadow me-1";
                chip.innerHTML =
                    `${area} <i onclick="removeChip(${i})" style="cursor:pointer;" class="fas fa-window-close"></i>`;
                parent.appendChild(chip);
            }

            getDonors();
        }

        function removeChip(index) {
            const parent = document.getElementById('locations');
            removeAllChildNodes(parent);

            state.areas.splice(index, 1);
            addChips();
        }

        function removeAllChildNodes(parent) {
            while (parent.firstChild) {
                parent.removeChild(parent.firstChild);
            }
        }

        function addArea() {
            const area = document.getElementById('area').value.toLowerCase();
            if (area.length > 0) {
                state.areas.push(area);
                document.getElementById('area').value = "";
                addChips();
            }
        }

        function addDonors() {
            const parent = document.getElementById('donors');
            removeAllChildNodes(parent);
            for (let j = 0; j < donors.length; j++) {
                const element = donors[j];
                const donor = document.createElement('div');
                donor.className = "border rounded p-4 my-2";
                donor.innerHTML = `
                    <h2>
                        ${ element.name }
                    </h2>
                    <h5>
                        Phone: ${ element.phone }
                    </h5>
                    <h5>
                        Blood Group: ${ element.blood_group }
                    </h5>
                    <h5>
                        Area: ${ element.area }, ${ element.city }
                    </h5>
                `
                parent.appendChild(donor);
            }
        }
        addDonors();

        function getDonors() {
            state.search = document.getElementById('search').value;
            state.group = document.getElementById('group').value;

            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "/api/donors", true);
            xhttp.setRequestHeader('Content-Type', 'application/json');
            xhttp.send(JSON.stringify(state));

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const response = JSON.parse(xhttp.responseText);
                    console.log("Success",response );
                    donors = response.donors.data;
                    addDonors();
                }
            };
        }
    </script>
@endsection
