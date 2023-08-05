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
        var employeeNameHiddenField = document.getElementById("emp-name");
        employeeNameHiddenField.value = result.name;
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
  //   console.log("here delete click");
  //   var deleteIcon = this;
  //   var alertBox = document.getElementsByClassName('project-remove-box-card')[0];
  //   alertBox.style.display = "block";
  //   document.getElementsByClassName("list-container")[0].style.filter = "blur(5px)";
  //   var employeeId = deleteIcon.parentElement.parentElement.querySelector('input[name=employeeId]').value;
  //   document.querySelector("#delete_emp_id").value = employeeId;
  reloadDeleteProjectForm();
  });
});

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("project-add").addEventListener("click", function () {
    reloadAddNewProjectForm();
  });
});

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("cancel-delete").addEventListener("click", function () {
    var alertBox = document.getElementsByClassName('project-remove-box-card')[0];
    alertBox.style.display = "";
    document.getElementsByClassName("list-container")[0].style.filter = "";
    document.querySelector("#delete_emp_id").value = "";
  });
});

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("cancel-add-new").addEventListener("click", function () {
    hideErrorMessages();
    var alertBox = document.getElementsByClassName('project-add-box-card')[0];
    alertBox.style.display = "";
    document.getElementsByClassName("list-container")[0].style.filter = "";
    document.querySelector("#delete_emp_id").value = "";
  });
});

/*
* show save form and background blur and change title to Add New Employee
*/
function reloadAddNewProjectForm() {
    var alertBox = document.getElementsByClassName('project-add-box-card')[0];
    alertBox.style.display = "block";

    var employeeIdSelectBox = document.getElementById("emp-id-select");
    var employeeId = employeeIdSelectBox.value;
    
    var employeeIdHiddenField = document.getElementById("save-project-emp-id");
    employeeIdHiddenField.value = employeeId;

    var employeeNameTextField = document.getElementById("emp-name");
    var employeeName = employeeNameTextField.value;

    var employeeNameHiddenField = document.getElementById("save-project-emp-name");
    employeeNameHiddenField.value = employeeName;
    
    var employeeEndDateTextField = document.getElementById("emp-end-date");
    var employeeName = employeeEndDateTextField.value;

    var employeeEndDateHiddenField = document.getElementById("save-project-end-date");
    employeeEndDateHiddenField.value = employeeName;

    var employeeStartDateTextField = document.getElementById("emp-start-date");
    var employeeName = employeeStartDateTextField.value;

    var employeeStartDateHiddenField = document.getElementById("save-project-start-date");
    employeeStartDateHiddenField.value = employeeName;

    var employeeProjectSelectBox = document.getElementById("emp-project-select");
    var projectName = employeeProjectSelectBox.options[employeeProjectSelectBox.selectedIndex].innerText;
    
    var employeeProjectHiddenField = document.getElementById("save-project-name");
    employeeProjectHiddenField.value = projectName;
}

function reloadDeleteProjectForm() {
  var alertBox = document.getElementsByClassName('project-remove-box-card')[0];
  alertBox.style.display = "block";

  var employeeIdSelectBox = document.getElementById("emp-id-select");
    var employeeId = employeeIdSelectBox.value;
    console.log("id" + employeeId);
    
    var employeeIdHiddenField = document.getElementById("delete-project-emp-id");
    employeeIdHiddenField.value = employeeId;

    var employeeNameTextField = document.getElementById("emp-name");
    var employeeName = employeeNameTextField.value;
    console.log("name" + employeeName);

    var employeeNameHiddenField = document.getElementById("delete-project-emp-name");
    employeeNameHiddenField.value = employeeName;

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
        var employeeNameTextField = document.getElementsByName("employee_name")[0];
        employeeNameTextField.value = '';
      });
}

function hideErrorMessages() {
  var elements = document.querySelectorAll('.hide');
  elements.forEach(function (element) {
    element.style.display = 'none';
  });
}

// Get the drop area element
var dropArea = document.getElementById('drop-area');

// Add event listeners for drag and drop events
dropArea.addEventListener('dragenter', handleDragEnter, false);
dropArea.addEventListener('dragover', handleDragOver, false);
dropArea.addEventListener('dragleave', handleDragLeave, false);
dropArea.addEventListener('drop', handleDrop, false);

// Add event listener for file selection using the file input
var fileInput = document.getElementById('file-input');
fileInput.addEventListener('change', handleFiles, false);

// Handle drag enter event
function handleDragEnter(e) {
  e.preventDefault();
  dropArea.classList.add('dragging');
}

// Handle drag over event
function handleDragOver(e) {
  e.preventDefault();
}

// Handle drag leave event
function handleDragLeave(e) {
  e.preventDefault();
  dropArea.classList.remove('dragging');
}

// Handle drop event
function handleDrop(e) {
  e.preventDefault();
  dropArea.classList.remove('dragging');

  // Prevent default behavior of the drop event
  e.preventDefault();
  e.stopPropagation();

  var files = e.dataTransfer.files;
  handleFiles(files);
}

// Handle file selection event
function handleFiles(files) {
  for (var i = 0; i < files.length; i++) {
    // Perform any necessary file processing here
    console.log(files[i].name);
  }
}

