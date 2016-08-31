<!DOCTYPE html>
<html ng-app>
<head>
    <title>Task manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/normalize.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/main.css" rel="stylesheet" media="screen">
    <script src="js/angular.min.js"></script>
    <script src="js/app.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="wrap">

        <!-- Begin page content -->

        
        <div class="container" ng-controller="TodoCtrl">
            <div class="page-header text-center">
                <h1>Simple todo lists</h1>
                <h3>from ruby garage</h3>
            </div>
            <!-- todo list -->
            <div class="todo-list" ng-repeat="project in projects">
                <div class="todo-list-head">
                    <div class="row clearfix">
                        <span class="glyphicon glyphicon-calendar"></span>
                        <span class="text" ng-hide="doProjectEdit">{{project.name}}</span>
                        <input type="text" ng-model="project.name" class="" ng-show="doProjectEdit"/>
                    <div class="pull-right haed-buttons">
                        <a href="" ng-click="doProjectEdit = !doProjectEdit"><span class="glyphicon glyphicon-pencil"></span></a> | <a href="" ng-click="removeProject(project.id)"><span class="glyphicon glyphicon-trash"></span></a>
                    </div>
                    </div>
                    <div class="row"></div>
                </div>
                <div class="todo-list-add">
                    <div class="row">
                        <div class="col-xs-1 text-right">
                            <a href="#"><span class="glyphicon glyphicon-plus big-plus"></span></a>
                        </div>
                        <div class="col-xs-10">
                            <form ng-submit="addTask(project.id, taskName)">
                            <div class="input-group">
                                <input type="text" class="form-control" ng-model="taskName" name="taskName[{{project.id}}]">
                                  <span class="input-group-btn">
                                      <input type="submit" class="btn btn-default btn-green" value="Add task" />
                                  </span>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="todo-list-body">
                    <!-- task row -->
                    <div class="todo-list-row clearfix" ng-repeat="task in project.tasks">
                        <div class="row">
                        <div class="col-xs-1">
                            <div class="pull-left todo-check">
                                <input type="checkbox" ng-model="task.status" ng-true-value="1" ng-false-value="0">
                            </div>
                            <div class="separator pull-right"></div>
                        </div>
                        <div class="col-xs-9">
                            <span class="text" ng-hide="doEdit">{{task.name}}</span>
                            <input type="text" ng-model="task.name" class="" ng-show="doEdit"/>
                        </div>
                        <div class="col-xs-2 text-center todo-buttons">
                            <div>
                            <a href="" ng-click="moveTask(project.id, task.id, -1)"><span class="glyphicon glyphicon-arrow-up"></span></a><a href="" ng-click="moveTask(project.id, task.id, 1)"><span class="glyphicon glyphicon-arrow-down"></span></a> | <a href="" ng-click="doEdit = !doEdit"><span class="glyphicon glyphicon-pencil"></span></a> | <a href="" ng-click="removeTask(project.id, task.id)"><span class="glyphicon glyphicon-trash"></span></a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- task row END -->
                </div>
            </div>
            <div class="project-add">
                <div class="row text-center">
                    <a href="" class="btn btn-default btn-lg btn-add" ng-click="addProject()"><span class="glyphicon glyphicon-plus"></span> Add TODO List</a>
                </div>
            </div>
            <!-- todo list END-->
        </div>

</div>
<div class="footer text-center">
    &copy; Ruby Garage
</div>
<!--
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
-->
</body>
</html>