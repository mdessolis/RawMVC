<script>

function updateList(){
  let data = new FormData(searchform);
  
  fetch("?option=CountriesFlags&task=api&search="+ search.value)
  .then((response) => {
    if (!response.ok)
      throw new Error("Errore")
    else {
      return response.json()
    }
      
  })
  .then((data) => {
    let tbody = document.querySelector("table tbody");
    tbody.innerHTML = '';
    for(let row of data){
      tbody.innerHTML += `
        <tr>
          <td>${row.country_id}</td>
          <td>${row.name}</td>
          <td>${row.region_name}</td>
        </tr>
      `;
    } 
  })
  .catch((reason) => console.log(reason))
}

window.onload = updateList;

</script>

<form id="searchform" onsubmit="updateList(); return false">
  <div>
    <label for="search">Search</label>
    <input type="search" name="search" id="search" oninput="updateList()">
    <input type="hidden" name="option" value="CountriesFlags">
    <input type="hidden" name="task" value="api_get">
  </div>
</form>

<table class="table table-bordered caption-top">
  <caption class="text-center"><h1>Countries</h1></caption>
  <thead>
    <tr>
      <th>ID</th><th>Name</th><th>Region</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>