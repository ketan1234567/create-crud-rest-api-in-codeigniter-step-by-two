<html>
    <head>
        <title>CURD REST API in Codeigniter</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>


        <style>
            #pagination_links {
                margin-top: 20px;
                text-align: center;
            }

            #pagination_links .pagination a {
                color: #333;
                background-color: #fff;
                border: 1px solid #ccc;
                padding: 6px 12px;
                text-decoration: none;
                margin: 0 3px;
                border-radius: 3px;
            }

            #pagination_links .pagination strong {
                color: #fff;
                background-color: #337ab7;
                border: 1px solid #337ab7;
                padding: 6px 12px;
                text-decoration: none;
                margin: 0 3px;
                border-radius: 3px;
            }

            #pagination_links .pagination a:hover {
                background-color: #eee;
            }
            button.dt-button.buttons-pdf.buttons-html5 {
                background-color: green;
                padding: 7px;
                color: white;
            }
            button.dt-button.buttons-excel.buttons-html5 {
                background-color: green;
                padding: 7px;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <br />
            <h3 align="center">Create CRUD REST API in Codeigniter - 4</h3>
            <br />
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title">CRUD REST API in Codeigniter</h3>
                        </div>
                        <div class="col-md-6" align="right">
                            <button type="button" id="add_button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#userModal">Add</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <span id="success_message"></span>
                    <table class="table table-bordered table-striped display" id="example" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $row) { ?>

                            <tr>
                                <td><?php  echo $row->first_name;?></td>
                                <td><?php echo $row->last_name; ?></td>
                                <td><button type="button" name="edit" class="btn btn-warning btn-xs edit" id="<?php  echo $row->id;?> ">Edit</button></td>
                                <td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="<?php  echo $row->id;?> ">Delete</button></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add User</h4>
                </div>
                <div class="modal-body">
                    <label>Enter First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" />
                    <span id="first_name_error" class="text-danger"></span>
                    <br />
                    <label>Enter Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" />
                    <span id="last_name_error" class="text-danger"></span>
                    <br />
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" id="user_id" />
                    <input type="hidden" name="data_action" id="data_action" value="Insert" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="pagination_links">
    <ul class="pagination">
        <?php echo $this->pagination->create_links(); ?>
    </ul>
</div>

<!-- Include jQuery and DataTables JS -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


<script src="https://cdn.datatables.net/buttons/2.3.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> <!---Excel File for Required Line-->
<script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.html5.min.js"></script>

<script type="text/javascript" language="javascript">
    $(document).ready(function () {
        function fetch_data() {
            $.ajax({
                url: "<?php echo base_url(); ?>test_api/action",
                method: "POST",
                data: { data_action: "fetch_all" },
                success: function (data) {
                    $("tbody").html(data);
                },
            });
        }

        fetch_data();

        $("#add_button").click(function () {
            $("#user_form")[0].reset();
            $(".modal-title").text("Add User");
            $("#action").val("Add");
            $("#data_action").val("Insert");
            $("#userModal").modal("show");
        });

        $(document).on("submit", "#user_form", function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url() . 'test_api/action' ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        $("#user_form")[0].reset();
                        $("#userModal").modal("hide");
                        fetch_data();
                        if ($("#data_action").val() == "Insert") {
                            $("#success_message").html('<div class="alert alert-success">Data Inserted</div>');
                        }
                    }

                    if (data.error) {
                        $("#first_name_error").html(data.first_name_error);
                        $("#last_name_error").html(data.last_name_error);
                    }
                },
            });
        });

        $(document).on("click", ".edit", function () {
            var user_id = $(this).attr("id");
            $.ajax({
                url: "<?php echo base_url(); ?>test_api/action",
                method: "POST",
                data: { user_id: user_id, data_action: "fetch_single" },
                dataType: "json",
                success: function (data) {
                    $("#userModal").modal("show");
                    $("#first_name").val(data.first_name);
                    $("#last_name").val(data.last_name);
                    $(".modal-title").text("Edit User");
                    $("#user_id").val(user_id);
                    $("#action").val("Edit");
                    $("#data_action").val("Edit");
                },
            });
        });

        $(document).on("click", ".delete", function () {
            var user_id = $(this).attr("id");
            if (confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    url: "<?php echo base_url(); ?>test_api/action",
                    method: "POST",
                    data: { user_id: user_id, data_action: "Delete" },
                    dataType: "JSON",
                    success: function (data) {
                        if (data.success) {
                            $("#success_message").html('<div class="alert alert-success">Data Deleted</div>');
                            fetch_data();
                        }
                    },
                });
            }
        });
        var table = $("#example").DataTable({
            dom: "Bfrtip",
            buttons: [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
                {
                    extend: "excelHtml5",
                    text: "Download Excel",
                    customize: function (xlsx) {
                        var sheet = xlsx.xl.worksheets["sheet1.xml"];
                        // Hide Edit and Delete columns
                        $('row c[r^="C"]', sheet).attr("s", "1");
                        $('row c[r^="D"]', sheet).attr("s", "1");
                    },
                },
                {
                    extend: "pdfHtml5",
                    text: "Download PDF",
                    customize: function (doc) {
                        // Hide edit and delete columns

                        doc.defaultStyle.alignment = "center";

                        doc.content[1].table.body.forEach(function (row) {
                            row.splice(-2, 2);

                            row.forEach(function (cell) {
                                cell.alignment = "center";
                            });
                        });
                    },
                },
            ],
        });
    });
</script>
