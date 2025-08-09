<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Training</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Training</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-info">
                    <i class="fa fa-plus"></i>
                    <a data-toggle="modal" data-target="#addTrainingModal" class="text-white"> Add Training </a>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Training List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Training Type</th>
                                        <th>Trainer</th>
                                        <th>Employee</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($trainings as $training): ?>
                                    <tr>
                                        <td><?= $training->type ?></td>
                                        <td><?= $training->trainer ?></td>
                                        <td><?= $training->employee ?></td>
                                        <td><?= date('jS \of F Y', strtotime($training->start_date)) ?></td>
                                        <td><?= date('jS \of F Y', strtotime($training->end_date)) ?></td>
                                        <td><?= $training->status ?></td>
                                        <td>
                                            <a href="editTraining?id=<?= $training->id ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil-square-o"></i></a>
                                            <a href="deleteTraining?id=<?= $training->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this training?')"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Training Modal -->
<div class="modal fade" id="addTrainingModal" tabindex="-1" role="dialog" aria-labelledby="addTrainingModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addTrainingModalLabel">Add Training</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" action="addTraining" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Training Type</label>
                        <input type="text" name="type" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Trainer</label>
                        <input type="text" name="trainer" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Employee</label>
                        <input type="text" name="employee" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Upcoming">Upcoming</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('backend/footer'); ?>