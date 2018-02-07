@extends('layouts.app')

@section('content')
<br/>

<div class="container" id="blogApp">

    <div class="row">

        <div class="col-md-12 text-right">
            <button class="btn btn-primary" v-on:click="createForm = false" v-if="createForm">Hide Form</button>
            <button class="btn btn-primary" v-on:click="loadForm()" v-else>Create Post</button>
        </div>
        <div class="col-md-12" v-if="createForm">

            <div class="col-md-12">
                <h2 class="text-center theme-clr">Create Post</h2>
                <p v-if="error" v-for="msg in messages" class="padding-off text-red">@{{ msg }}</p>
                <form @submit.prevent="saveRecord" action="#">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Title:</label>
                            <input type="text" class="form-control" placeholder="Blog Title" v-model="newData.title" required>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Description:</label>
                            <textarea class="form-control" v-model="newData.content"></textarea>
                        </div>
                        <div class="form-group">
                            <div v-if="!image">
                                <label for="pwd">Select an image:</label>
                                <input type="file" class="btn btn-primary" v-on:change="onFileChange">
                            </div>
                            <div class="col-md-12" v-else>
                                <div class="col-md-6">
                                    <img :src="image" class="img-responsive" />
                                </div>
                                <div class="col-md-6">
                                    <input type="file" class="btn btn-primary" style="width:247px; margin-top:6px;" v-on:change="onFileChange">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Category:</label>
                            <select class="form-control" v-model="newData.category_id" required multiple>
                                <option v-for="category in categories" v-bind:value="category.id">
                                    @{{ category.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pwd">Country:</label>
                            <select class="form-control" v-on:change="getAllCity($event)" v-model="newData.country_id" required>
                                <option v-for="country in countries" v-bind:value="country.id">
                                    @{{ country.name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group" v-on:change="getAllState($event)" v-if="Object.keys(cities).length">
                            <label for="pwd">City:</label>
                            <select class="form-control" v-model="newData.city_id" required>
                                <option v-for="city in cities" v-bind:value="city.id">
                                    @{{ city.name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group" v-on:change="getAllArea($event)" v-if="Object.keys(states).length">
                            <label for="pwd">State:</label>
                            <select class="form-control" v-model="newData.state_id" required>
                                <option v-for="state in states" v-bind:value="state.id">
                                    @{{ state.name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group" v-if="Object.keys(areaData).length">
                            <label for="pwd">Area:</label>
                            <select class="form-control" v-model="newData.area_id" required>
                                <option v-for="area in areaData" v-bind:value="area.id">
                                    @{{ area.name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-default">Submit</button>
                            <button type="button" class="btn btn-default" v-on:click="loadForm()">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12">
            <div v-for="item in blogs" class="page-header col-md-6">
                <div class="blog">
                    <h5 class="text-right">
                        <button class="btn btn-xs btn-danger" v-on:click="deletePost(item)">Delete</button>
                        <button class="btn btn-xs btn-warning" v-on:click="editPost(item)">Edit</button>
                    </h5>
                    <img :src="IMG_PATH+item.image" class="img-responsive" alt="Image not found" />
                    <h5 class="text-center">@{{ item.title }}</h5>
                    <p>@{{ item.content }}</p>
                    <p class="padding-off"><b class="theme-clr">Blog Category:</b>
                        <span v-for="(category, index) in item.blog_category">
                            <span v-if="index == item.blog_category.length - 1">@{{ category.category.name }}</span>
                            <span v-else>@{{ category.category.name }}, </span>
                        </span>
                    </p>
                    <p class="padding-off"><b class="theme-clr">Country:</b> <span v-if="item.country">@{{ item.country.name }}</span></p>
                    <p class="padding-off"><b class="theme-clr">City:</b> <span v-if="item.city">@{{ item.city.name }}</span></p>
                    <p class="padding-off"><b class="theme-clr">State:</b> <span v-if="item.state">@{{ item.state.name }}</span></p>
                    <p class="padding-off"><b class="theme-clr">Area:</b> <span v-if="item.area">@{{ item.area.name }}</span></p>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection

@section('script')
    <script>
        /*const CSRF_TOKEN = '{!! csrf_token() !!}';*/
        const IMG_PATH = '{!! url('uploads').'/blogs/' !!}';
        Vue.http.headers.common['X-CSRF-TOKEN'] = '{!! csrf_token() !!}';
        //axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
        /*axios.defaults.headers.post['enctype'] = 'multipart/form-data';*/
        var app = new Vue({
            el: '#blogApp',
            data: {
                blogs: {},
                newData: {},
                categories: {},
                countries: {},
                cities: {},
                states: {},
                areaData: {},
                createForm: false,
                image: '',
                error: false,
                messages: {}
            },
            created: function(){
                this.loadPage();
                this.loadCategories();
            },
            methods: {
                loadPage: function(){
                    this.$http.get('/api/blog/list')
                            .then(function(response){
                                this.blogs = response.data;
                            });
                },
                loadCategories: function(){
                    this.$http.get('/api/country/list')
                            .then(function(response){
                                this.countries = response.data;
                            });
                    this.$http.get('/api/category/list')
                            .then(function(response){
                                this.categories = response.data;
                            });
                },
                saveRecord: function(){
                    this.newData.image = this.image;
                    this.$http.post('/blog/store', this.newData)
                            .then(function(response){
                                if(response.data.status == 1){
                                    this.messages = response.data.message;
                                    this.error = true;
                                } else {
                                    this.loadPage();
                                    this.newData = {};
                                    this.newData.category_id = [];
                                    this.resetAllObject();
                                    this.image = '';
                                }
                            }).catch(function(error){console.log(error)});
                },
                deletePost: function(item){
                    this.$http.post('/api/blog/delete', item)
                            .then(function(response){
                                this.blogs.splice(this.blogs.indexOf(item), 1);
                                this.loadPage();
                            });
                },
                editPost: function(item){
                    this.newData = {};
                    this.newData.id = item.id;
                    this.newData.title = item.title;
                    this.newData.content = item.content;
                    this.image = IMG_PATH+''+item.image;
                    let obj = this;
                    this.newData.category_id = [];
                    $.each(item.blog_category, function(key){
                        obj.newData.category_id.push(item.blog_category[key].category.id);
                    });
                    this.newData.country_id = item.country_id;
                    this.getRecordById('city',item.country_id,1);
                    this.newData.city_id = item.city_id;
                    this.getRecordById('state',item.city_id,2);
                    this.newData.state_id = item.state_id;
                    this.getRecordById('area',item.state_id,3);
                    this.newData.area_id = item.area_id;
                    this.createForm = true;
                },
                getRecordById: function(url,id,type){
                    this.$http.get('/api/country/'+url+'/'+id)
                            .then(function(response){
                                if(type === 1){this.cities = response.data;}
                                if(type === 2){this.states = response.data;}
                                if(type === 3){this.areaData = response.data;}
                            });
                },
                getAllCity: function(event){
                    this.resetAllObject();
                    var id = event.target.value;
                    this.getRecordById('city',id,1);
                },
                getAllState: function(event){
                    this.states = {};
                    var id = event.target.value;
                    this.getRecordById('state',id,2);
                },
                getAllArea: function(event){
                    this.areaData = {};
                    var id = event.target.value;
                    this.getRecordById('area',id,3);
                },
                loadForm: function(){
                    this.newData = {};
                    this.resetAllObject();
                    this.createForm = !this.createForm;
                    this.image = '';
                },
                resetAllObject: function(){
                    this.cities = {};
                    this.states = {};
                    this.areaData = {};
                },

                onFileChange: function(e){
                    var files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createImage(files[0]);
                },
                createImage: function(file) {
                    var image = new Image();
                    var reader = new FileReader();
                    var vm = this;

                    reader.onload = (e) => {
                        vm.image = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }/*,
                removeImage: function (e) {
                    this.image = '';
                }*/
            }
        });
    </script>
@endsection