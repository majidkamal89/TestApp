@extends('layouts.app')

@section('content')
    <br/>

    <div class="container" id="countryApp">

        <span class="row">

            <span v-for="item1 in countries">
                <div class="col-md-12 blog" style="border: 1px solid lightgray;padding:0;">
                    <h5 style="border-bottom: 1px solid lightgray; margin-left:0; padding: 5px;">@{{ item1.name }}</h5>
                    <div class="col-md-4" v-for="item2 in item1.city">
                        <h5 style="margin-left:0;">@{{ item2.name }}</h5>
                        <div class="col-md-12" style="padding:0;">
                            <span v-for="item3 in item2.state">

                                <div class="col-md-12" style="padding:0;">
                                    <h5 style="margin-left:0;">@{{ item3.name }}</h5>
                                    <span v-for="(item4, index) in item3.area">
                                        <span v-if="index == item3.area.length - 1">@{{ item4.name }}</span>
                                        <span v-else>@{{ item4.name }}, </span>
                                    </span>
                                </div>

                            </span>
                        </div>
                    </div>
                </div>
            </span>


            {{--<div class="col-md-12">
                <h2>Countries</h2>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 5%;"></th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody v-for="item1 in countries">
                    <tr v-bind:id="item1.id">
                        <td class="text-center"><span class="glyphicon glyphicon-plus" v-on:click="listCity(item1)"></span></td>
                        <td>@{{ item1.name }}</td>
                        <td><span v-if="item1.status">In Active</span><span v-else>Active</span></td>
                        <td>
                            <button class="btn btn-xs btn-danger" v-on:click="deleteRecord(item1)">Delete</button>
                            <button class="btn btn-xs btn-warning" v-on:click="editRecord(item1)">Edit</button>
                        </td>
                    </tr>

                    <tr v-for="item2 in item1.city" style="background-color: #98cbe8;">
                        <td></td>
                        <td>@{{item2.name}}</td>
                        <td><span v-if="item2.status">In Active</span><span v-else>Active</span></td>
                        <td></td>
                    </tr>
                    </tbody>

                </table>
            </div>--}}

        </span>
    </div>
@endsection

@section('script')
    <script>
        /*const CSRF_TOKEN = '{!! csrf_token() !!}';*/
        Vue.http.headers.common['X-CSRF-TOKEN'] = '{!! csrf_token() !!}';
        var app = new Vue({
            el: '#countryApp',
            data: {
                countries: {}
            },
            created: function () {
                this.loadPage();
            },
            methods: {
                loadPage: function () {
                    this.$http.get('/api/country/list/all')
                            .then(function (response) {
                                this.countries = response.data;
                            });
                },
                deleteRecord: function (item) {
                    this.$http.post('/api/country/delete', item)
                            .then(function (response) {
                                this.countries.splice(this.countries.indexOf(item), 1);
                                this.loadPage();
                            });
                }
            }
        });
    </script>
@endsection