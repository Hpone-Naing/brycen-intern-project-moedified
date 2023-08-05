/*
* login page's password field's toggle button (eye icon)
* toogle password and text when toogle button click
*/
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("toggle-password").addEventListener("click", function () {
    var passwordInput = document.getElementsByName("password")[0];
    console.log(passwordInput);
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
  });
});

/*
* if employee list page's  delete icon click, 
* show alert box, blur background, and set employee_id value of this row to input type hidden's id="#emp_id"
*/
function showAlertMessage(a) {
  console.log("here delete click");
  var deleteIcon = a;
  var alertBox = document.getElementsByClassName('alart-box-card')[0];
  alertBox.style.display = "block";
  document.getElementsByClassName("list-container")[0].style.filter = "blur(5px)";
  var employeeId = deleteIcon.parentElement.parentElement.querySelector('input[name=employeeId]').value;
  document.querySelector("#delete_emp_id").value = employeeId;
}

/*
* if alert box's cancle button click,
* hide alert box, remove blur background and remove employee_id from input type hidden's id="emp_id"
*/
document.addEventListener("DOMContentLoaded", function () {
  document.getElementsByName("alert_msg_cancel")[0].addEventListener("click", function () {
    var deleteIcon = this;
    var alertBox = document.getElementsByClassName('alart-box-card')[0];
    alertBox.style.display = "";
    document.getElementsByClassName("list-container")[0].style.filter = "";
    document.querySelector("#delete_emp_id").value = "";
  });
});

/** 
 * get file from input type file and than read file as readasdataurl. after finish
*/
function loadPhoto(event) {
  var e = event.target;
  var file = e.files[0];
  var reader = new FileReader();

  reader.onload = function (event) {
    var image = document.createElement('img');
    image.src = event.target.result;
    image.style.width = '130px';
    image.style.height = '130px';
    image.style.position = "relative";
    image.style.left = "0px";
    image.style.top = "0px";
    var preview = document.getElementById("preview");
    preview.innerHTML = '';
    preview.appendChild(image);
  };
  reader.readAsDataURL(file);
}

var employeeId = "";
// function fetchApi(url) {
//   fetch(url, {
//     method: 'GET', 
//     headers: {
//         'Content-Type': 'application/json',
//         'Accept': 'application/json',
//         'url': '/payment',
//         "X-CSRF-Token": document.querySelector('input[name=_token]').value
//     },
// }).then(response => response.json())
// .then(data => {
//     employeeId =  data.data;
//     console.log(employeeId);
//   })
//   .catch(error => {
//     console.error('Error:', error);
//   });
//   return employeeId;
// }

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

/**
 * add new button click, show save form
 */
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("save").addEventListener("click", function () {
    reloadSaveForm();
  });
});

/**
 * server validation error messages form all  fields will hide
 * */
function hideErrorMessages() {
  var elements = document.querySelectorAll('.hide');
  elements.forEach(function (element) {
    element.style.display = 'none';
  });
}
/**
 * hide save form and resert save form and clear choosen image from img tag
 */
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("window-close").addEventListener("click", function () {
    hideErrorMessages();
    document.getElementById("save-form").style.display = '';
    document.getElementById("parent").style.filter = "blur(0px)";
    var form = document.getElementById("save-create");
    form.reset();
    var imagePreview = document.getElementById("preview");
    var image = imagePreview.childNodes[0];
    image.src = "";

  });
});

function blurBackground() {
  document.getElementsByClassName("list-container")[0].style.filter = "blur(5px)";
}

function removeBlue() {
  document.getElementsByClassName("list-container")[0].style.filter = "";
}

/*
* show save form and background blur and change title to Add New Employee
*/
function reloadSaveForm() {
  $saveForm = document.getElementById("save-form").style.display = 'flex';
  document.getElementById("parent").style.filter = "blur(5px)";
  var formTitle = document.getElementsByName("form-title")[0];
  formTitle.innerHTML = "Add New Employee";
  var employeeIdTextField = document.getElementsByName("employee_id")[0];
  var employeeIdHiddenField = document.getElementsByName("employee_id")[1];
  fetchApi("api/employees/make-employees-id/")
    .then(result => {
      console.log('Result:', result);
      employeeIdTextField.value = result;
      employeeIdHiddenField.value = result;
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

function loadEditForm(a) {
  //var editBtn = this;//event.target;
  var employeeId = a.parentElement.parentElement.querySelector('input[name=employeeId]').value;
  console.log(employeeId);
  reloadSaveForm();
  fetch('api/employees/get-employees-ids/' + employeeId, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'url': '/payment',
      "X-CSRF-Token": document.querySelector('input[name=_token]').value
    },
  }).then(response => response.json())
    .then(data => {
      console.log(data); // Process the returned data
      var employeeIdField = document.getElementsByName("employee_id")[0];
      var nameField = document.getElementsByName("name")[0];
      var nrcField = document.getElementsByName("nrc")[0];
      var phoneField = document.getElementsByName("phone")[0];
      var emailField = document.getElementsByName("email")[0];
      var genderField = document.querySelectorAll('input[type="radio"]');
      var dateOfBirthField = document.getElementsByName("date_of_birth")[0];
      var addressField = document.getElementsByName("address")[0];
      //var languagesField = document.getElementsByName("languages[]")[0];//document.querySelectorAll('input[typFielde="checkbox"]');
      // const careerPartField = document.querySelector('select[name="career_part"]'); 
      var levelField = document.getElementsByName("level")[0];
      var imageField = document.querySelector("img")[0];
      console.log(data.data.image);
      // image.src = data.data.image;
      employeeIdField.value = data.data.employee_id;
      nameField.value = data.data.name;
      nrcField.value = data.data.nrc;
      phoneField.value = data.data.phone;
      emailField.value = data.data.email;
      dateOfBirthField.value = data.data.date_of_birth;
      addressField.value = data.data.address;

      genderField.forEach(radio => {
        console.log(radio.value);
        if (radio.value == data.data.gender) {
          radio.checked = true;
        } else {
          radio.checked = false;
        }
      });

      // languagesField.forEach(checkbox => {
      //   console.log(data.data.language.toString().split(" "));
      //   if (data.data.language.toString().trim().split(" ").includes(checkbox.value)) {
      //     checkbox.checked = true;
      //   } else {
      //     checkbox.checked = false;
      //   }
      // });

      // for (let i = 0; i < careerPartField.options.length; i++) {
      //   const option = careerPartField.options[i];
      //   console.log(option.value);
      //   if (option.value == data.data.career_part) {
      //     console.log("here true");
      //     careerPartField.options[i].selected = true;
      //     break;
      //   }
      // }
      var selectedValue = '{{ $selectedValue }}';
      console.log(selectedValue);

      selectedValue = "2"; // The value you want to select
      const careerPartField = document.querySelector('select[name="career_part"]'); // Select the career_part select element using its name attribute

      for (let i = 0; i < careerPartField.options.length; i++) {
        const option = careerPartField.options[i];
        if (option.value === selectedValue) {
          option.selected = true;
          break;
        }
      }



      for (let i = 0; i < levelField.options.length; i++) {
        const option = levelField.options[i];
        if (option.value == data.data.level) {
          console.log("here true");
          option.style.background = "red";
          option.selected = true;
          break;
        }
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

/**
 * when reset button click clear text field, check items to unckecked
 */
function resetForm() {
  var serverValidaionError = document.getElementById('myDiv').classList.remove('save-form-reload');


  var inputFields = document.querySelectorAll('input[type="text"]');
  var textAreaFields = document.getElementsByName("address")[0];
  textAreaFields.value = '';
  for (var i = 0; i < inputFields.length; i++) {
    if (inputFields[i].name !== "employee_id") {
      inputFields[i].value = "";
    }
  }

  document.getElementsByName("phone")[0].value = "";

  // Uncheck checkboxes
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  for (var j = 0; j < checkboxes.length; j++) {
    checkboxes[j].checked = false;
  }

  // Unselect radio buttons
  var radioButtons = document.querySelectorAll('input[type="radio"]');
  for (var k = 0; k < radioButtons.length; k++) {
    radioButtons[k].checked = false;
  }
  //hideErrorMessages();
}

/**
 * check validate name maximun 10
 */
function checkValidName(event) {
  var value = event.target.value;
  var nameSpan = document.getElementById("nameErr");
  if (value.length > 10) {
    nameSpan.innerHTML = "maximum 10 characters";
    nameSpan.style.display = "block";
  } else {
    nameSpan.style.display = "none";
  }
}


document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("career-part-select").addEventListener("change", function () {
    console.log("here career part select box");
    var careerPartSelectBox = this;
    var selectedCareerPartValue = careerPartSelectBox.value;
    var employeeTable = document.getElementById("employee-table");
    var rows = employeeTable.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
    var matchlevels = [];
    for (var i = 0; i < rows.length; i++) {
      var row = rows[i];
      var careerPartsDatas = row.cells[4].innerText;
      var levelDatas = row.cells[5].innerText;
      if(selectedCareerPartValue == careerPartsDatas) {
        
      }
    }

  });
});

function clearFileInput() {
  var fileInput = document.getElementById('file-upload');
  var newFileInput = document.createElement('input');
  
  newFileInput.type = 'file';
  newFileInput.name = fileInput.name;
  newFileInput.id = fileInput.id;
  newFileInput.setAttribute('data-image', fileInput.getAttribute('data-image'));
  newFileInput.addEventListener('change', loadPhoto);
  
  fileInput.parentNode.replaceChild(newFileInput, fileInput);
}