<template>
    <div>

<!--        <div v-if="!$gate.isAdminOrAuthor()">-->
<!--            <not-found></not-found>-->
<!--        </div>-->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ title }}</h3>

                        <select id="user" @change="searchResults">
                            <option value="">إختر المستخدم ........</option>
                            <option v-for="(user, index) in users" :key="user.id" :value="user.id">{{ user.name }}
                            </option>
                        </select>

                        <div class="box-tools">
                            <button class="btn btn-primary" data-toggle="modal" @click="newModal()" :data-target="'#' + modalTitle"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive p-0">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>رقم الدفتر</th>
                                <th>البدايه</th>
                                <th>النهايه</th>
                                <th>التحكم</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(book, index) in books.data" :key="book.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ book.number }}</td>
                                <td>{{ book.start }}</td>
                                <td>{{ book.end }}</td>
                                <td>
                                    <a href="#" :data-target="'#' + modalTitle" @click="editModal(book)"><i class="fa fa-edit blue"></i></a> / <a href="#" @click="deleteData(book.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <pagination :data="books" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.box -->

        <div class="modal fade" :id="modalTitle" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <form @submit.prevent="editMode ? updateData() : createData()">
                        <div class="modal-header">
                            <h4 class="modal-title" style="display:inline-block" v-show="editMode" id="addNewLabel1">تعديل بيانات {{ subtitle }}</h4>
                            <h4 class="modal-title" style="display:inline-block" v-show="!editMode" id="addNewLabel">إضافة {{ subtitle }} جديد</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.number" type="number" name="number" placeholder="number"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('number') }">
                                <has-error :form="form" field="number"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.start" type="number" name="start" placeholder="start"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('start') }">
                                <has-error :form="form" field="start"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.end" type="number" name="end" placeholder="end"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('end') }">
                                <has-error :form="form" field="end"></has-error>
                            </div>

                            <div class="form-group">
                                <select name="user_id" v-model="form.user_id" :class="{ 'is-invalid': form.errors.has('user_id') }"
                                        class="form-control">
                                    <option value="">إختر المستخدم ........</option>
                                    <option v-for="(user, index) in users" :key="user.id" :value="user.id">{{
                                        user.name }}
                                    </option>
                                </select>
                                <has-error :form="form" field="user_id"></has-error>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" v-show="editMode" class="btn btn-success">تعديل</button>
                            <button type="submit" v-show="!editMode" class="btn btn-primary">إضافه</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                editMode: false,
                modalTitle: 'books',
                title: 'الدفاتر',
                subtitle: 'دفتر',
                books: {},
                users: {},
                form: new Form({
                    id: '',
                    number : '',
                    start : '',
                    end : '',
                    user_id: ''
                })
            }
        },
        props:['id'],
        methods: {
            searchResults() {
                axios.get('api/book?user=' + $("#user").val())
                    .then(response => {
                        this.books = response.data;
                    });
            },
            getResults(page = 1) {
                axios.get('api/book?page=' + page)
                    .then(response => {
                        this.books = response.data;
                    });
            },
            updateData() {
                this.$Progress.start();
                this.form.put('api/book/'+this.form.id).then(() => {
                    // Fire.$emit('afterCreate');

                    $("#" + this.modalTitle).modal('hide');
                    this.loadData();
                    toast.fire({
                        icon: 'success',
                        title: 'تم التعديل بنجاح'
                    });

                    this.$Progress.finish();
                })
                    .catch(() => {
                        swal("Failed", "There Was Something Wrong.", "warning");
                    });
            },
            newModal() {
                this.editMode = false;
                this.form.reset();
                // $("#" + this.modalTitle).modal('show');
            },
            editModal(book) {
                this.editMode = true;
                this.form.reset();
                $("#" + this.modalTitle).modal('show');
                this.form.fill(book);
            },
            deleteData(id) {
                swal.fire({
                    title: 'هل أنت متأكد أنك تريد الحذف',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'لا',
                    confirmButtonText: 'نعم'
                }).then((result) => {
                    this.$Progress.start();
                    if (result.value) {
                        this.form.delete('api/book/' + id).then(() => {
                            this.loadData();
                            this.$Progress.finish();
                            toast.fire({
                                icon: 'success',
                                title: 'تم الحذف بنجاح'
                            });
                            // Fire.$emit('afterCreate');
                        }).catch(() => {
                            swal.fire("Failed", "There Was Something Wrong.", "warning");
                        });

                    }
                });
            },
            loadData() {
                // if(this.$gate.isAdminOrAuthor()) {
                    axios.get('api/book').then(({data}) => (this.books = data));
                // }
            },
            createData() {
                this.$Progress.start();
                $("#" + this.modalTitle).modal('hide');
                this.form
                    .post("api/book")
                    .then(() => {
                        // Fire.$emit("afterCreate");
                        $("#" + this.modalTitle).modal("hide");
                        toast.fire({
                            icon: "success",
                            title: "تم الحفظ بنجاح"
                        });
                        this.loadData();
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        toast.fire({
                            icon: "Failed",
                            title: "لم يتم الحفظ "
                        });
                    });
            }
        },
        created() {
            axios.get('api/user?user=all').then(({data}) => (this.users = data));
            // Fire.$on('searching', () => {
            //     let query = this.$parent.search;
            //     axios.get('api/findbook?q=' + query)
            //         .then((data) => {
            //             this.books = data.data;
            //         })
            //         .catch(() => {
            //             swal.fire("Failed", "There Was Something Wrong.", "warning");
            //         });
            // });
            this.loadData();
            // Fire.$on('afterCreate', () => {
            //     this.loadData();
            // });
            //setInterval(() => this.loadData(), 3000);
        }
    }
</script>
