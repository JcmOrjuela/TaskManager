const app = new Vue({
    el: '#app',
    data: {
        date_current: new Date().toISOString().substr(0, 10),
        usersList: [],
        usersString: '',
        newUser: '',
        task: {},
        params: {
            tasks: {},
            users: {},
            statuses: {}
        }
    },
    methods: {
        addUsers() {
            this.usersList.push(
                this.newUser,
            )
        },
        rmvUser(index) {
            this.usersList.splice(index, 1)
        },
        nameStatus(id) {
            let status = Object.values(this.params.statuses).filter(
                status => status.id == id
            )
            status = status.map(
                status => status.name
            )

            return status[0]
        }
    }
});

// Leer todas las tareas existentes
fetch("app/App.php/Task/read")
    .then(response => response.json())
    .then(result => {
        app.params.tasks = result
    })
    .catch(error => console.log('error', error));

// leer todos los usuarios existentes
fetch("app/App.php/User/read")
    .then(response => response.json())
    .then(result => {
        app.params.users = result
    })
    .catch(error => console.log('error', error));

fetch("app/App.php/Status/read")
    .then(response => response.json())
    .then(result => {
        app.params.statuses = result
    })
    .catch(error => console.log('error', error));

app.getData = (id_task) => {
    let url = `app/App.php/Task/read?id=${id_task}`
    fetch(url)
        .then(response => response.json())
        .then(result => {
            app.task = result[0]
        })
        .catch(error => console.log('error', error));

    url = `app/App.php/task/users?id=${id_task}`
    fetch(url)
        .then(response => response.json())
        .then(result => {
            app.usersList = Object.values(result).map((user) => user.id)
        })
        .catch(error => console.log('error', error));

}

function delTask(event) {

    let id = event.target.id.replace('task_', '');
    const url = `app/App.php/Task/del?id=${id}`

    alertify.confirm('<br>Precaución', "Seborrará la tarea permanentemete, ¿Desea continuar?",
        function() {
            let requestOptions = {
                method: 'DELETE',
                redirect: 'follow'
            };
            fetch(url, requestOptions)
                .then(response => response.text())
                .then(result => {
                    alertify.success('Ok');
                    location.reload();
                })
                .catch(error => console.log('error', error));

        },
        function() {
            alertify.error('Cancel');
        });



}