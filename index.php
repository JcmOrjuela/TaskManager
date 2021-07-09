<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Managger</title>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="Views/Css/styles.css">
</head>

<body clas>
    <div id="app">
        <div class="container mt-5 mx-5">
            <center>
                <h1>Administrador de Tareas</h1>
            </center>

            <!-- Agregar nueva tarea -->
            <div class="d-flex justify-content-end">
                <button id="newTask" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addTask">➕ Nueva Tarea</button>
            </div>
            <!-- fin Agregar nueva tarea -->

            <!-- Todas las tareas -->
            <div class="row mt-5">
                <div v-for="task in params.tasks" class="col-md-2">
                    <div class="card text-dark  mb-3" style="max-width: 18rem;">
                        <div :class="['card-header'
                        , {'bg-success': task.id_status==1, 
                            'bg-info': task.id_status==2,
                            'bg-warning': task.id_status==4,
                            'bg-danger': task.id_status==3},
                            'text-white' ,
                            'd-flex' ,'justify-content-between']
                            ">
                            {{task.create_at}}
                            {{nameStatus(task.id_status)}}
                            <b><a onclick="delTask(event)" class=" btn" :id="'task_'+task.id">X</a></b>
                        </div>
                        <div class="card-body btn" data-bs-toggle="modal" data-bs-target="#editTask" @click="getData(task.id)">
                            <h5 class="card-title">{{task.name}}</h5>
                            <p class="card-text">{{task.description}}</p>
                        </div>
                        <div class="card-footer bg-transparent border-success">Entregar el {{task.expire_at}}</div>
                    </div>
                </div>
            </div>
            <!-- fin Todas las tareas -->
        </div>

        <!-- modal new task -->
        <div class="modal" tabindex="-1" id="addTask">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark">👀Nueva Tarea</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="app/App.php/Task/add" class="form" method="POST">
                            <div class="row">
                                <!-- name task -->
                                <div class="col-md-7">
                                    <label for="name">Título</label>
                                    <input class="form-control" type="text" name="name" placeholder="Título" required>
                                    <textarea class="form-control mt-3" name="description" id="" cols="30" rows="6" placeholder="Detalle" required></textarea>
                                </div>
                                <!--end name task -->
                                <!-- users, dates, status -->
                                <div class="col-md-5">
                                    <label>Asignar a</label>
                                    <select class="form-select" v-model="newUser" @change="addUsers" required>
                                        <option value="" selected disabled>Colaboradores</option>
                                        <option v-for="user of params.users" :value="user.id">
                                            {{user.name}}
                                        </option>
                                    </select>
                                    <div class="mt-3">
                                        <label for="created_at">Creado en:</label>
                                        <input class="form-control" type="date" name="create_at" v-model="date_current" required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="expire_at">Finalizar en:</label>
                                        <input class="form-control" type="date" name="expire_at" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-auto" v-for="(user, index) of usersList">
                                    <span class="badge bg-dark ">
                                        {{params.users[user-1].name}}
                                        <span class="badge bg-danger btn" @click="rmvUser(index)">X</span>
                                    </span>
                                </div>
                            </div>
                            <div v-show="false">
                                <input type="text" name="users" :value="usersList.join(',')">
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <label for="status">Estado</label>
                                    <select class="form-select" name="id_status">
                                        <option v-for="status of params.statuses" :value="status.id">
                                            {{status.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!--end users, dates, status -->
                            <div class="modal-footer mt-5">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!--end modal new task -->

        <!-- modal edit task -->
        <div class="modal" tabindex="-1" id="editTask">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark">✍Editar Tarea</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="app/App.php/Task/edit" class="form" method="POST">
                            <div class="row">
                                <!-- name task -->
                                <div class="col-md-7">
                                    <label for="name">Título</label>
                                    <input class="form-control" type="text" name="name" placeholder="Título" :value="task.name" required>
                                    <textarea class="form-control mt-3" name="description" id="" cols="30" rows="6" placeholder="Detalle" :value="task.description" required></textarea>
                                </div>
                                <!--end name task -->
                                <!-- users, dates, status -->
                                <div class="col-md-5">
                                    <label>Asignar a</label>
                                    <select class="form-select" v-model="newUser" @change="addUsers" required>
                                        <option value="" selected disabled>Colaboradores</option>
                                        <option v-for="user of params.users" :value="user.id">
                                            {{user.name}}
                                        </option>
                                    </select>
                                    <div class="mt-3">
                                        <label for="created_at">Creado en:</label>
                                        <input class="form-control" type="date" name="create_at" :value="task.create_at" required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="expire_at">Finalizar en:</label>
                                        <input class="form-control" type="date" :value="task.expire_at" name="expire_at" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-auto" v-for="(user, index) of usersList">
                                    <span class="badge bg-dark ">
                                        {{params.users[user-1].name}}
                                        <span class="badge bg-danger btn" @click="rmvUser(index)">X</span>
                                    </span>
                                </div>
                            </div>
                            <div v-show="false">
                                <input type="text" name="users" :value="usersList.join(',')">
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <label for="status">Estado</label>
                                    <select class="form-select" name="id_status">
                                        <option v-for="status of params.statuses" :value="status.id" :selected="status.id==task.id_status">
                                            {{status.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!--end users, dates, status -->
                            <div class="modal-footer mt-5">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!--end modal edit task -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="Views/Js/app.js"></script>
</body>

</html>