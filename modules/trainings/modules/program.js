
$(function () {

    $('#start_date').on('change', function () {
        $('#end_date').attr('min', $(this).val());
    });

    if (typeof toastr !== 'undefined') {

        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-bottom-right",
            preventDuplicates: true,
            timeOut: 3000
        };
    }

   
});

function programSelect() {
     var programId = $('#program_id').val();

    $('#project_id option').hide();

    $('#project_id option:first').show();

    $('#project_id option[data-program-id="' + programId + '"]').show();

    $('#project_id').val('');
}

function submitProgram() {

    var csrfToken = $('#csrf_token').val();

    var programCode = $('#program_code').val();
    var programName = $('#program_name').val();
    var description = $('#description').val();
    var programid = $('#program_id').val();

    $.ajax({
        url: SITE_URL + '/modules/trainings/modules/action.php',
        type: 'POST',
        dataType: 'json',
        data: {
            saveProgram: true,
            csrf_token: csrfToken,
            program_id: programid,
            program_code: programCode,
            program_name: programName,
            description: description
        },

        success: function (res) {

            if (res.status === "success") {

                $('#addProgramModal').modal('hide');

                $('#addProgramModal').on('hidden.bs.modal', function () {
                    location.reload();
                });

            } else {
                alert(res.message);
            }
        },

        error: function (xhr) {
            alert("Error: " + xhr.responseText);
        }
    });
}

function editProgram(id, code, name, description) {

    $('#program_action').val('edit');
    $('#program_id').val(id);

    $('#program_code').val(code);
    $('#program_name').val(name);
    $('#description').val(description);

    $('#addProgramModalLabel').text('Edit Program');

    $('#addProgramModal').modal('show');
}

function resetProgramInput() {

    $('#program_action').val('add');
    $('#program_id').val('');

    $('#program_code').val('');
    $('#program_name').val('');
    $('#description').val('');

    $('#addProgramModalLabel').text('Add Program');

    $('#addProgramModal').modal('show');
}

function confirmDeleteProgram(programId, programName) {

    $('#delete_program_id').val(programId);
    $('#delete_program_name').text(programName);

    $('#deleteProgramModal').modal('show');
}

function deleteProgram() {

    var csrfToken = $('#csrf_token').val();

    $.ajax({
        url: SITE_URL + '/modules/trainings/modules/action.php',
        type: 'POST',
        dataType: 'json',
        data: {
            deleteProgram: true,
            csrf_token: csrfToken,
            program_id: $('#delete_program_id').val()
        },

        success: function (res) {

            if (res.status === 'success') {

                $('#deleteProgramModal').modal('hide');

                location.reload();

            } else {

                alert(res.message);
            }
        },

        error: function (xhr) {
            alert(xhr.responseText);
        }
    });
}

//Project

function submitProject() {

    var csrfToken = $('#csrf_token').val();

    var programid = $('#program_id').val();
    var projectid = $('#project_id').val();
    var projectCode = $('#project_code').val();
    var projectName = $('#project_name').val();
    var description = $('#description').val();
    var startdate = $('#start_date').val();
    var enddate = $('#end_date').val();

    $.ajax({
        url: SITE_URL + '/modules/trainings/modules/action.php',
        type: 'POST',
        dataType: 'json',
        data: {
            saveProject: true,
            csrf_token: csrfToken,
            program_id: programid,
            project_id: projectid,
            project_code: projectCode,
            project_name: projectName,
            description: description,
            start_date: startdate,
            end_date: enddate,
        },

        success: function (res) {

            if (res.status === "success") {

                toastr.success("Project successfully updated");

                $('#addProjectModal').modal('hide');

                setTimeout(function () {
                    location.reload();
                }, 1500);

            } else {
                toastr.error(res.message);
            }
        },

        error: function (xhr) {
            alert("Error: " + xhr.responseText);
        }
    });
}

function editProject(
        projectId,
        projectCode,
        projectName,
        description,
        startDate,
        endDate
        ) {

    $('#project_id').val(projectId);
    $('#project_code').val(projectCode);
    $('#project_name').val(projectName);
    $('#description').val(description);
    $('#start_date').val(startDate);
    $('#end_date').val(endDate);

    $('#addProgramModalLabel').text('Edit Project');

    $('#addProjectModal').modal('show');
}

function addProject() {

    $('#project_id').val('');
    $('#project_code').val('');
    $('#project_name').val('');
    $('#description').val('');
    $('#start_date').val('');
    $('#end_date').val('');

    $('#addProgramModalLabel').text('Add New Project');

    $('#addProjectModal').modal('show');
}

function confirmDeleteProgram(projectId) {

    $('#delete_project_id').val(projectId);

    $('#deleteProjectModal').modal('show');
}


function deleteProject() {

    var csrfToken = $('#csrf_token').val();

    $.ajax({
        url: SITE_URL + '/modules/trainings/modules/action.php',
        type: 'POST',
        dataType: 'json',
        data: {
            deleteProject: true,
            csrf_token: csrfToken,
            project_id: $('#delete_project_id').val()
        },

        success: function (res) {

            if (res.status === 'success') {

                $('#deleteProjectModal').modal('hide');

                location.reload();

            } else {

                alert(res.message);
            }
        },

        error: function (xhr) {
            alert(xhr.responseText);
        }
    });
}

