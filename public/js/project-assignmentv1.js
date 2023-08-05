async function fetchApi(url) {
  try {
    const response = await fetch(url, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'url': '/payment',
        "X-CSRF-Token": document.querySelector('input[name=_token]').value
      },
    });
    const data = await response.json();
    employeeId = data.data;
    console.log(employeeId);

    return employeeId;
  } catch (error) {
    console.error('Error:', error);
    throw error;
  }
}


document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("emp-id-select").addEventListener("change", function () {
    var employeeIdSelectbox = this;
    var employeeId = employeeIdSelectbox.value;
    fetchApi("api/employees/get-employees-optional-columns-lazy-load/" + employeeId)
      .then(result => {
        console.log('Result:', result);
        var employeeNameTextField = document.getElementsByName("employee_name")[0];
        employeeNameTextField.value = result.name;
      })
      .catch(error => {
        console.error('Error:', error);
        var employeeNameTextField = document.getElementsByName("employee_name")[0];
        employeeNameTextField.value = '';
      });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("project-delete").addEventListener("click", function () {
    fetchApi("api/projects/all")
      .then(results => {
        deletedProjectSelect = document.getElementById('delete-project-select');
        for (project of results) {
          option = document.createElement('option');
          option.value = project.id;
          option.innerText = project.name;
          deletedProjectSelect.appendChild(option);
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  });
});