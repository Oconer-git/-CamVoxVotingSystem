function registerStudent() {
    const id = document.getElementById('id').value.trim();
    const email = document.getElementById('email').value.trim();
    const fullname = document.getElementById('fullname').value.trim();
    const dob = document.getElementById('dob').value.trim();
    const gender = document.getElementById('gender').value.trim();
    const address = document.getElementById('address').value.trim();
    const course = document.getElementById('course').value.trim();
    const cpnum = document.getElementById('cpnum').value.trim();
    const pass = document.getElementById('pass').value.trim();
    const college = document.getElementById('college').value.trim();
  
    // Check if any required field is empty
    if (!id || !email || !fullname || !dob || !gender || !address || !course || !cpnum || !pass || !college) {
      alert('Please fill in all fields.');
      return; // Prevents further execution if any field is empty
    }
  
    const studentData = {
      id,
      email,
      fullname,
      dob,
      gender,
      address,
      course,
      cpnum,
      pass,
      college
    };
  
    fetch('http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/registerStudent', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(studentData),
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok.');
      }
      return response.json();
    })
    .then(data => {
      const registrationResultDiv = document.getElementById('registrationResult');
      if (data.status === 'success') {
        registrationResultDiv.innerHTML = `<p>${data.message}</p>`;
        window.location.reload();
      } else {
        registrationResultDiv.innerHTML = `<p>${data.message}</p>`;
      }
    })
    .catch(error => {
      console.error('Error:', error);
      const registrationResultDiv = document.getElementById('registrationResult');
      registrationResultDiv.innerHTML = '<p>An error occurred while registering the student.</p>';
    });
  }
  
  
  function searchAndDisplay() {
    const searchId = document.getElementById('searchId').value.trim();
  
    // Check if searchId is empty
    if (!searchId) {
      alert('Please enter an ID to search.');
      return;
    }
  
    fetch('http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/searchStudent', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ id: searchId }),
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok.');
      }
      return response.json();
    })
    .then(data => {
      const registrationStatusDiv = document.getElementById('registrationStatus');
      const registrationForm = document.getElementById('registrationForm');
  
      if (data.status === 'success') {
        const student = data.data;
        document.getElementById('id').value = student.ID;
        document.getElementById('email').value = student.email;
        document.getElementById('fullname').value = student.fullname;
        document.getElementById('dob').value = student.dob;
        document.getElementById('gender').value = student.gender;
        document.getElementById('address').value = student.address;
        document.getElementById('course').value = student.course;
        document.getElementById('cpnum').value = student.cpnum;
        document.getElementById('pass').value = student.pass;
        document.getElementById('college').value = student.college;
  
        registrationStatusDiv.innerHTML = '<p></p>';
      } else if (data.status === 'error') {
        alert('No student found with the entered ID.');
        clearFormFields();
      } else {
        registrationStatusDiv.innerHTML = `<p>${data.message}</p>`;
        clearFormFields();
      }
    })
    .catch(error => {
      console.error('Error:', error);
      const registrationStatusDiv = document.getElementById('registrationStatus');
      registrationStatusDiv.innerHTML = '<p>Student ID doesnt exist</p>';
      clearFormFields();
    });
  }
  
  
      function updateStudent() {
    const studentData = {
      id: document.getElementById('id').value,
      email: document.getElementById('email').value,
      fullname: document.getElementById('fullname').value,
      dob: document.getElementById('dob').value,
      gender: document.getElementById('gender').value,
      address: document.getElementById('address').value,
      course: document.getElementById('course').value,
      cpnum: document.getElementById('cpnum').value,
      pass: document.getElementById('pass').value,
      college: document.getElementById('college').value
    };
  
    fetch('http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/updateStudent', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(studentData),
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok.');
      }
      return response.json();
    })
    .then(data => {
      const registrationResultDiv = document.getElementById('registrationResult');
      if (data.status === 'success') {
        registrationResultDiv.innerHTML = `<p>${data.message}</p>`;
        window.location.reload();
      } else {
        registrationResultDiv.innerHTML = `<p>${data.message}</p>`;
      }
    })
    .catch(error => {
      console.error('Error:', error);
      const registrationResultDiv = document.getElementById('registrationResult');
      registrationResultDiv.innerHTML = '<p>An error occurred while updating student data.</p>';
    });
  }
  
  function deleteStudent() {
      const studentId = document.getElementById('searchId').value;
  
      fetch('http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/deleteStudent', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: studentId }),
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok.');
        }
        return response.json();
      })
      .then(data => {
        const registrationResultDiv = document.getElementById('registrationResult');
        if (data.status === 'success') {
          registrationResultDiv.innerHTML = `<p>${data.message}</p>`;
          // Reload the page upon successful deletion
          window.location.reload();
        } else {
          registrationResultDiv.innerHTML = `<p>${data.message}</p>`;
        }
      })
      .catch(error => {
        console.error('Error:', error);
        const registrationResultDiv = document.getElementById('registrationResult');
        registrationResultDiv.innerHTML = '<p>An error occurred while deleting the student.</p>';
      });
    }
  
    function loadStudentInfo() {
      fetch('http://localhost/-CamVoxVotingSystem/public/api_endpoints.php/loadStudentInfo')
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok.');
          }
          return response.json();
        })
        .then(data => {
          if (data.status === 'success') {
            displayStudentData(data.data);
          } else {
            document.getElementById('studentData').innerHTML = `<p>${data.message}</p>`;
          }
        })
        .catch(error => {
          console.error('Error:', error);
          document.getElementById('studentData').innerHTML = '<p>An error occurred while fetching data.</p>';
        });
    }
  
    function displayStudentData(students) {
      const studentDataDiv = document.getElementById('studentData');
      let html = '<table border="1"><tr><th>ID</th><th>Email</th><th>Full Name</th><th>Date of Birth</th><th>Gender</th><th>Address</th><th>Course</th><th>Contact Number</th><th>Password</th><th>College</th></tr>';
  
      students.forEach(student => {
        html += `<tr><td>${student.ID}</td><td>${student.email}</td><td>${student.fullname}</td><td>${student.dob}</td><td>${student.gender}</td><td>${student.address}</td><td>${student.course}</td><td>${student.cpnum}</td><td>${student.pass}</td><td>${student.college}</td></tr>`;
      });
  
      html += '</table>';
      studentDataDiv.innerHTML = html;
    }
  
    window.onload = loadStudentInfo;