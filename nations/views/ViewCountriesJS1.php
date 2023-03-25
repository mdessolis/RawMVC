<?php defined('APP') or die(); ?>
<script>

/**
 * updateList is called when the page is loaded and at every
 * change of the search word in the input#search tag.
 * Calls the webservice with a GET request to receive all countries
 * who have in their name or in the region name the search word.
 * After receiving the list and converting it from the json format
 * rebuilds the tbody section of the table present in the popup
 * 
 */
function updateList(){
  fetch("?option=Countries&task=api&search="+search.value, {
    method: 'GET'
  })
  .then((response) => {
    if (!response.ok)
      throw new Error("Errore")
    else {
      return response.json()
    }
      
  })
  .then((data) => {
    let tbody = document.querySelector("#tableCountries tbody");
    tbody.innerHTML = '';
    for(let row of data){
      tbody.innerHTML += `
        <tr>
          <td>${row.country_id}</td>
          <td>${row.name}</td>
          <td>${row.region_name}</td>
          <td>
              <a href="#" onclick="edit(${row.country_id})"><span class="bi-pencil" role="img" aria-label="Edit"></span></a>
              <a href="#" onclick="del(${row.country_id})"><span class="bi-trash"  role="img" aria-label="Del"></span></a>
        </tr>
      `;
    } 
  })
  .catch((reason) => console.log(reason))
}

/**
 * register is called by the submit event of the form.
 * It calls the webservice with a POST method (create/update) and includes
 * in the body of the request all the input fields presents in the form#inputForm tag.
 * These body data are not passed in JSON format but using the default application/x-www-form-urlencoded
 * or multipart/form-data. In this way the webservice will receive the data directly 
 * converted inside the variables $_POST or $_REQUEST
 * 
 */
function register() {
  fetch("?option=Countries&task=api",
  {
    method: "POST",
    body: new FormData(inputform)
  })
  .then( (response) => response.json() )
  .then( (data) => {
    messages.innerHTML = data;
    inputform.reset();
  })
}

/**
 * edit is called by the icon link edit (pen) in the table list of Countries.
 * It calls the webservice to receive the record to be modified and, once received the data,
 * copy the fields values in their corresponding input tags in the form#inputForm
 */
function edit(id){
  fetch("?option=Countries&task=api&id="+id,
  {method: "GET"})
  .then( (response) => response.json())
  .then( (data) => {
    document.querySelector("#country_id").value = data.country_id;
    document.querySelector("#name").value = data.name;
    document.querySelector("#area").value = data.area;
    document.querySelector("#national_day").value = data.national_day;
    document.querySelector("#country_code2").value = data.country_code2;
    document.querySelector("#country_code3").value = data.country_code3;
    for(let r of document.querySelector("#region_id").options)
      if (r.value == data.region_id){
        r.selected = true;
        break;
      }
    messages.innerHTML = ''
  })
}

/**
 * del is called by the icon link delete (trash icon) in the table list of Countries.
 * It calls the webservice with a DELETE method and passes to it the id of the country
 * to be deleted.
 * Data is passed in JSON format since with the DELETE method php doesn't store the data
 * in the $_POST or $_REQUEST variables so we have to do the conversion manually (have a look
 * to api_DELETE in REST.php)
 */
function del(id){
  fetch("?option=Countries&task=api",
  { 
    method: "DELETE",
    headers: {"Content-Type": "application/json; charset=UTF-8"},
    body: JSON.stringify({"id": id})
  })
  .then( (response) => response.json())
  .then( (data) => {
    messages.innerHTML = data;
    updateList();
  })
  
}

window.onload = updateList;

</script>
<form onsubmit="register(); updateList(); return false;" id="inputform">
  <fieldset class="bg-dark text-white">
    <legend>Edit/Insert</legend>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="country_id" class="form-label">ID</label>
      </div>
      <div class="col-9">
        <input type="text" name="country_id"  class="form-control" id="country_id" >
      </div>
    </div>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="name" class="form-label">Name</label>
      </div>
      <div class="col-9">
        <input type="text" name="name"  class="form-control" id="name">
      </div>
    </div>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="area" class="form-label">Area (km<sup>2</sup>)</label>
      </div>
      <div class="col-9">
        <input type="number" name="area"  class="form-control" id="area">
      </div>
    </div>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="name" class="form-label">National Day</label>
      </div>
      <div class="col-9">
        <input type="date" name="national_day"  class="form-control" id="national_day">
      </div>
    </div>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="country_code2" class="form-label">Country code (2 letters)</label>
      </div>
      <div class="col-9">
        <input type="text" name="country_code2"  class="form-control" id="country_code2">
      </div>
    </div>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="country_code3" class="form-label">Country code (3 letters)</label>
      </div>
      <div class="col-9">
        <input type="text" name="country_code3"  class="form-control" id="country_code3">
      </div>
    </div>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="region_id" class="form-label">Region</label>
      </div>
      <div class="col-9">
        <select name="region_id" id="region_id" class="form-control" id="region_id">
          <option value="0">Choose a region</option>
          <?php
          foreach ($this->model->getRegions() as $region) { 
            echo "<option value=\"{$region->region_id}\" >
                          {$region->continent_name} - {$region->region_name}
                        </option>";
          }
          ?>
        </select>

      </div>
    </div>
    <p class="m-3">
      <button type="submit" name="reg" class="btn btn-primary">Register</button>
    </p>
    <h3 id="messages" class="text-center m-3"></h3>
  </fieldset>
</form>

<form id="searchform" onsubmit="updateList(); return false" class="m-3">
  <div>
    <label for="search">Search</label>
    <input type="search" name="search" id="search" oninput="updateList()">
  </div>
</form>

<table id="tableCountries" class="table table-bordered caption-top">
  <caption class="text-center"><h1>Countries</h1></caption>
  <thead>
    <tr>
      <th>ID</th><th>Name</th><th>Region</th><th>tasks</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>