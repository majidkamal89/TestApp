@extends('layouts.app')

@section('content')
<br/>

<div class="container" id="categoryApp">

    <div class="row">

        <div class="col-md-12 text-right">
            <button class="btn btn-primary" v-on:click="createForm = false" v-if="createForm">Hide Form</button>
            <button class="btn btn-primary" v-on:click="loadForm()" v-else>Add New</button>
        </div>
        <div class="col-md-12" v-if="createForm">
            <div class="col-md-12">
                <h2 class="text-center theme-clr">Add Category</h2>
                <form @submit.prevent="saveCategory" action="#">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Category Name:</label>
                            <input type="text" class="form-control" placeholder="Category Name" v-model="newData.name" required>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group text-left" style="margin-bottom: 0; padding-top: 17px;">
                            <button type="submit" class="btn btn-default">Submit</button>
                            <button type="button" class="btn btn-default" v-on:click="loadForm()">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12">
            <h2>Categories</h2>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in categories">
                    <td>@{{ item.name }}</td>
                    <td><span v-if="item.status">In Active</span><span v-else>Active</span></td>
                    <td>
                        <button class="btn btn-xs btn-danger" v-on:click="deleteCategory(item)">Delete</button>
                        <button class="btn btn-xs btn-warning" v-on:click="editCategory(item)">Edit</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection

@section('script')
    <script>
        /*const CSRF_TOKEN = '{!! csrf_token() !!}';*/
        Vue.http.headers.common['X-CSRF-TOKEN'] = '{!! csrf_token() !!}';
        var app = new Vue({
            el: '#categoryApp',
            data: {
                categories: {},
                newData: {},
                createForm: false
            },
            created: function(){
                this.loadPage();
            },
            methods: {
                loadPage: function(){
                    this.$http.get('/api/category/list')
                            .then(function(response){
                                this.categories = response.data;
                            });
                },
                saveCategory: function(){
                    this.$http.post('/category/store', this.newData)
                            .then(function(response){
                                this.loadPage();
                                this.newData = {};
                            });
                },
                editCategory: function(item){
                    this.newData = {};
                    this.newData.name = item.name;
                    this.newData.id = item.id;
                    this.createForm = true;
                },
                deleteCategory: function(item){
                    this.$http.post('/api/category/delete', item)
                            .then(function(response){
                                this.categories.splice(this.categories.indexOf(item), 1);
                                this.loadPage();
                            });
                },
                loadForm: function(){
                    this.newData = {};
                    this.createForm = !this.createForm;
                }
            }
        });
    </script>
@endsection