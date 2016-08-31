function TodoCtrl($scope, $http) {
    var master = [
        {
            id: 1,
            name: 'prject1',
            tasks: [{id: 1, name: 'task1', status: "1"},
                    {id: 2, name: 'task2', status: "0"},
                    {id: 3, name: 'task3', status: "0"}]
        },
        {
            id: 2,
            name: 'prject2',
            tasks: [{id: 4, name: 'task1', status: "1"},
                    {id: 5, name: 'task2', status: "1"},
                    {id: 6, name: 'task3', status: "0"}]
        }
    ];





    
    $http({method: 'GET', url: 'app.php', data:{}}).
        success(function(data) {
        master = data;
        $scope.projects = angular.copy(master);
    }).
    error(function(data, status, headers, config) {
        console.log(data, status, headers, config);
    });
    //$scope.projects = angular.copy(master);

    $scope.removeProject = function(id) {
        $http({method: 'post', url: 'app.php?action=removeProject', data:{id:id}}).
            success(function(data) {
                angular.forEach($scope.projects, function(project, key) {
                    if (project.id == id)
                        $scope.projects.splice(key,1);
                });
            });
    };
    $scope.addProject = function() {
        $http({method: 'get', url: 'app.php?action=addProject', data:{}}).
            success(function(data) {
                $scope.projects.push({id:data, name: '', tasks: []});
            });
    }

    $scope.addTask = function(id, name) {
        $http({method: 'post', url: 'app.php?action=addTask', data:{id:id, name:name}}).
            success(function(data) {
                angular.forEach($scope.projects, function(project, key) {
                    if (project.id == id)
                        project.tasks.push({id: data, name: name, status: 0});
                });
            });
    };
    $scope.moveTask = function(projectId, taskId, direction) {
        var doForEach = true;
        angular.forEach($scope.projects, function(project, key) {
            if (project.id == projectId && doForEach)
            {
                angular.forEach(project.tasks, function(task, key) {
                    if (task.id == taskId && doForEach)
                    {
                        doForEach = false; // why no break?(
                        project.tasks.move(key, key+direction);
                    }
                });
            }
        });
    };
    $scope.removeTask = function(projectId, taskId){
        $http({method: 'post', url: 'app.php?action=removeTask', data:{id:taskId}}).
            success(function(data) {
                var doForEach = true;
                angular.forEach($scope.projects, function(project, key) {
                    if (project.id == projectId && doForEach)
                    {
                        angular.forEach(project.tasks, function(task, key) {
                            if (task.id == taskId && doForEach)
                            {
                                doForEach = false; // why no break?(
                                project.tasks.splice(key,1);
                            }
                        });
                    }
                });
            });

    }

}

Array.prototype.move = function (oldIndex, newIndex) {
//    if (newIndex >= this.length) {
//        var k = newIndex - this.length;
//        while ((k--) + 1) {
//            this.push(undefined);
//        }
//    }
    if (newIndex<0 || newIndex >= this.length)
        return this;
    this.splice(newIndex, 0, this.splice(oldIndex, 1)[0]);
    return this;
};