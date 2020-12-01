<template>
    <div>

        <!--        <div v-if="!$gate.isAdminOrAuthor()">-->
        <!--            <not-found></not-found>-->
        <!--        </div>-->
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ title }}</h3>

                <select id="user" @change="user">
                    <option value="">إختر المستخدم ........</option>
                    <option v-for="(user, index) in users" :data-index="index" :key="user.id" :value="user.id">{{
                        user.name }}
                    </option>
                </select>

                <select id="zone" @change="zone" disabled>
                    <option value="">إختر المنطقه ........</option>
                    <option v-for="(zone, index) in zones" :data-zone_name="zone.name" :key="zone.id" :value="zone.id">
                        {{
                        zone.name }}
                    </option>
                </select>

                <select id="delegate" disabled>
                    <option value="">إختر المندوب ........</option>
                    <option v-for="(delegate, index) in delegates" v-if="delegate.pivot.zone_id == zone_selected"
                            :data-delegate_name="delegate.name" :key="delegate.id"
                            :value="delegate.id">{{
                        delegate.name }}
                    </option>
                </select>

                <select id="crop">
                    <option value="">إختر المحصول ........</option>
                    <option v-for="(crop, index) in crops" :data-index="index" :key="crop.id" :value="crop.id">{{
                        crop.name }}
                    </option>
                </select>

                <select id="book" @change="searchResults" disabled>
                    <option value="">إختر الدفتر ........</option>
                    <option v-for="(book, index) in books" :data-index="index" :data-number="book.number" :key="book.id"
                            :value="book.id">{{
                        book.number }}
                    </option>
                </select>

                <div class="box-tools">
                    <button class="btn btn-primary" id="add" data-toggle="modal" @click="newModal()"
                            :data-target="'#' + modalTitle"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive p-0">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>الرقم</th>
                        <th>رقم الإيصال</th>
                        <th>الإسم</th>
                        <th>جوال</th>
                        <th>قيراط</th>
                        <th>المستخدم</th>
                        <th>التحكم</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(receipt, index) in receipts.data" :key="receipt.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ receipt.number }}</td>
                        <td>{{ receipt.name }}</td>
                        <td>{{ receipt.bag }}</td>
                        <td>{{ receipt.carat }}</td>
                        <td>{{ receipt.user_id }}</td>
                        <td>
                            <a href="#" :data-target="'#' + modalTitle" @click="editModal(receipt)"><i
                                class="fa fa-edit blue"></i></a> / <a href="#" @click="deleteData(receipt.id)"><i
                            class="fa fa-trash red"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <pagination :data="receipts" @pagination-change-page="getResults"></pagination>

            </div>
        </div>
        <!-- /.box -->

        <div class="modal fade" :id="modalTitle" tabindex="-1" role="dialog" aria-labelledby="addNewLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <form @submit.prevent="editMode ? updateData() : createData()">
                        <div class="modal-header">
                            <h4 class="modal-title" style="display:inline-block" v-show="editMode" id="addNewLabel1">
                                تعديل بيانات {{ subtitle }}</h4>
                            <h4 class="modal-title" style="display:inline-block" v-show="!editMode" id="addNewLabel">
                                إضافة {{ subtitle }} جديد</h4>
                            <input v-model="receipt_num" min="1" v-if="!editMode" @change="deleteRow(form.number.length)" type="number"
                                   placeholder="edit me">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="Name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input v-model="form.book_id" type="hidden" name="book_id" placeholder="Name"
                                               class="form-control"
                                               :class="{ 'is-invalid': form.errors.has('book_id') }">
                                        <input type="text" :value="number" class="form-control" disabled>
                                        <has-error :form="form" field="book_id"></has-error>
                                    </div>
                                    <div class="col-md-6" v-if="form.crop_id != ''">
                                        <input v-model="form.crop_id" type="hidden" name="crop_id" placeholder="Name"
                                               class="form-control"
                                               :class="{ 'is-invalid': form.errors.has('book_id') }">
                                        <input type="text" :value="crops[crop].name" class="form-control" disabled>
                                        <has-error :form="form" field="book_id"></has-error>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input v-model="form.zone_id" type="hidden" name="zone_id" placeholder="Name"
                                               class="form-control"
                                               :class="{ 'is-invalid': form.errors.has('zone_id') }">
                                        <input type="text" :value="zone_name" class="form-control" disabled>
                                        <has-error :form="form" field="zone_id"></has-error>
                                    </div>
                                    <div class="col-md-6">
                                        <input v-model="form.delegate_id" type="hidden" name="delegate_id"
                                               placeholder="Name"
                                               class="form-control"
                                               :class="{ 'is-invalid': form.errors.has('delegate_id') }">
                                        <input type="text" :value="delegate_name" class="form-control" disabled>
                                        <has-error :form="form" field="delegate_id"></has-error>
                                    </div>
                                </div>

                            </div>

                            <div class="quantities" v-if="!editMode">
                                <div class="form-group" v-for="n in ids">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input v-model="form.number[n]" type="text" name="number[]"
                                                   placeholder="number"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': form.errors.has('number') }" disabled>
                                            <has-error :form="form" field="number"></has-error>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="form.bag[n]" type="number" name="bag[]" placeholder="bag"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': form.errors.has('bag') }">
                                            <has-error :form="form" field="bag"></has-error>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="form.carat[n]" type="number" name="carat[]"
                                                   placeholder="carat"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': form.errors.has('carat') }">
                                            <has-error :form="form" field="carat"></has-error>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="quantities" v-else-if="editMode">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input v-model="form.number" type="text" name="number"
                                                   placeholder="number"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': form.errors.has('number') }" disabled>
                                            <has-error :form="form" field="number"></has-error>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="form.bag" type="number" name="bag" placeholder="bag"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': form.errors.has('bag') }">
                                            <has-error :form="form" field="bag"></has-error>
                                        </div>
                                        <div class="col-md-4">
                                            <input v-model="form.carat" type="number" name="carat"
                                                   placeholder="carat"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': form.errors.has('carat') }">
                                            <has-error :form="form" field="carat"></has-error>
                                        </div>
                                    </div>
                                </div>
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
                ids: [],
                editMode: false,
                modalTitle: 'receipts',
                title: 'الإيصالات',
                subtitle: 'إيصال',
                receipts: {},
                crop: '',
                number: '',
                zone_name: '',
                delegate_name: '',
                zone_selected: '',
                selected_book: '',
                start: '',
                lastNumber : '',
                users: {},
                zones: {},
                delegates: {},
                books: {},
                crops: {},
                receipt_num: 1,
                form: new Form({
                    id: '',
                    name: '',
                    number: [],
                    book_id: "",
                    delegate_id: '',
                    zone_id: '',
                    crop_id: '',
                    user_id: '',
                    bag: [],
                    carat: []
                })
            }
        },
        props: ['id'],
        methods: {
            user() {
                if ($("#user").val() != '') {
                    axios.get('api/user/' + $("#user").val())
                        .then(response => {
                            this.zones = response.data[0].zones;
                            this.delegates = response.data[0].delegates;
                            this.books = response.data[0].books;
                            $("#zone, #book").removeAttr('disabled');
                        });
                } else {
                    $("#zone, #book").attr('disabled', true);
                }
            },
            zone() {
                if ($("#zone").val() != '') {
                    this.zone_selected = $("#zone").val();
                    $("#delegate").removeAttr('disabled');
                } else {
                    $("#delegate").attr('disabled', true);
                }
            },
            searchBooks() {
                axios.get('api/book?userReceipt=' + $("#user").val())
                    .then(response => {
                        this.books = response.data;
                    });
            },
            searchDelegates() {
                axios.get('api/delegate?zoneReceipt=' + $("#zone").val())
                    .then(response => {
                        this.delegates = response.data;
                    });
            },
            searchResults() {
                if ($("#book").val() != '') {

                    $('#add').show();
                    $('#add').removeAttr('disabled');
                    axios.get('api/receipt?books=' + $("#book").val())
                        .then(response => {
                            this.receipts = response.data;

                            if (Object.keys(this.receipts.data).length === 0) {
                                this.selected_book = this.books[$("#book option:selected").data('index')].start;

                                this.start = this.selected_book;
                            } else {
                                axios.get('api/receipt?lastBook=' + $("#book").val())
                                    .then(response => {
                                        this.selected_book = response.data;

                                        // this.selected_book = this.lastNumber + 1;

                                        this.start = this.selected_book + 1;

                                    });
                            }

                        });
                } else {
                    $('#add').hide();
                    $('#add').attr('disabled', true);
                }

            },
            addRow() {
                var number = 0;
                for (var i = 1; i <= this.receipt_num; i++) {
                    if (i == 1) {
                        number = this.start;
                    } else {
                        number = this.start + i - 1;
                    }
                    // this.inputs.push({
                    //     number: number,
                    //     bag: i,
                    //     carat: i
                    // });
                    this.form.number.push(number);
                    this.form.bag.push(1);
                    this.form.carat.push(1);

                }
                this.ids = Object.keys(this.form.number);
            },
            deleteRow(index) {
                // this.inputs.splice(0, index);
                this.form.number.splice(0, index);
                this.form.bag.splice(0, index);
                this.form.carat.splice(0, index);
                this.addRow();
            },
            getResults(page = 1) {
                axios.get('api/receipt?page=' + page)
                    .then(response => {
                        this.receipts = response.data;
                    });
            },
            updateData() {
                this.$Progress.start();
                this.form.put('api/receipt/' + this.form.id).then(() => {
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
                this.form.user_id = $("#user").val();
                this.form.book_id = $("#book").val();
                this.form.crop_id = $("#book").val();
                this.crop = $("#crop option:selected").data('index');
                this.form.number[0] = this.start;
                this.form.zone_id = $("#zone").val();
                this.form.delegate_id = $("#delegate").val();
                this.number = $("#book option:selected").data('number');
                this.zone_name = $("#zone option:selected").data('zone_name');
                this.delegate_name = $("#delegate option:selected").data('delegate_name');
            },
            editModal(receipt) {
                this.editMode = true;
                this.form.reset();
                $("#" + this.modalTitle).modal('show');
                this.form.fill(receipt);
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
                        this.form.delete('api/receipt/' + id).then(() => {
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
                axios.get('api/receipt').then(({data}) => (this.receipts = data));
                // }
            },
            createData() {
                this.$Progress.start();
                $("#" + this.modalTitle).modal('hide');
                this.form
                    .post("api/receipt")
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
            // axios.get('api/delegate?delegate=all').then(({data}) => (this.delegates = data));
            // this.searchResults();
            axios.get('api/crop?crop=all').then(({data}) => (this.crops = data));
            this.loadData();

            this.deleteRow(1);
            // this.form.book_id = this.books.first.id;
            $("#add").hide();

        }
    }
</script>
