<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ (userDetails.title ? userDetails.title : '') + " " + (userDetails.first_name ? userDetails.first_name : '') + " " + (userDetails.middle_name ? userDetails.middle_name : '') + " " + (userDetails.second_name ? userDetails.second_name : '') }}
                        </h3>
                        <div class="card-tools">
                            <router-link :to="{ name: 'editMyProfile', params: { id:user.id } }" title="Edit" class="btn btn-success">
                                Edit <i class="fa fa-edit"></i>
                            </router-link>
                        </div>
                    </div>
                    <div class="card-body">
                        <section class="content">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                            <div v-if="userDetails.profile_image" class="text-center">
                                                <img
                                                :src="`/file?name=profile/${userDetails.profile_image}&disk=user_uploads`"
                                                alt
                                                class="img-user profile-user-img img-fluid img-circle"
                                                >
                                            </div>
                                            <div v-else class="text-center">
                                                <img
                                                :src="`/img/default-user.jpg`"
                                                alt
                                                class="img-user profile-user-img img-fluid img-circle"
                                                >
                                            </div> 
                                             <h3
                                                class="profile-username text-center"
                                            >{{(userDetails.title ? userDetails.title : '') + " " + (userDetails.first_name ? userDetails.first_name : '') + " " + (userDetails.middle_name ? userDetails.middle_name : '') + " " + (userDetails.second_name ? userDetails.second_name : '') }}</h3>
                                            <ul class="list-group list-group-unbordered mb-3">
                                                <li class="list-group-item">
                                                <b>Date Of Birth</b>
                                                <span class="float-right">{{ userDetails.date_of_birth | myDate }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                <b>Gender</b>
                                                <span v-if="userDetails.gender" class="float-right">Male</span>
                                                <span v-else class="float-right">Female</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 pt-2">
                                                        <strong>
                                                            <i class="fas fa-envelope-open"></i> Email
                                                        </strong>
                                                        <p class="text-muted ml-4">
                                                        {{ user.email }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6 pt-2">
                                                        <strong>
                                                        <i class="fas fa-phone fa-rotate-90"></i> Mobile Number
                                                        </strong>
                                                        <p class="text-muted ml-4">{{ userDetails.mobile_number | formatTel }}</p>
                                                    </div>
                                                    <div class="col-md-6 pt-2">
                                                        <strong>
                                                        <i class="fas fa-user-tie"></i> Profession
                                                        </strong>
                                                        <p class="text-muted ml-4">{{ userDetails.profession }}</p>
                                                    </div>
                                                    <div class="col-md-6 pt-2">
                                                        <strong>
                                                        <i class="fas fa-id-card-alt"></i> Department
                                                        </strong>
                                                        <p class="text-muted ml-4">{{ userDetails.department }}</p>
                                                    </div>
                                                    <div class="col-md-6 pt-2">
                                                        <strong>
                                                        <i class="fas fa-calendar-alt"></i> Join Date
                                                        </strong>
                                                        <p class="text-muted ml-4">{{ userDetails.join_date  | myDate}}</p>
                                                    </div>
                                                    
                                                    <div class="col-md-6 pt-2">
                                                        <strong>
                                                        <i class="fas fa-street-view"></i> Status
                                                        </strong>
                                                        <p class="text-muted ml-4" v-if="userDetails.user_status">Active</p>
                                                        <p class="text-muted ml-4" v-else>Active</p>
                                                    </div>
                                                    <div class="col-md-6 pt-2">
                                                        <strong>
                                                        <i class="fas fa-globe-asia"></i> Nationality
                                                        </strong>
                                                        <p v-if="userDetails.nationality" class="text-muted ml-4">{{ countryAll[userDetails.nationality] }}</p>

                                                    </div>                                                    
                                                    <div class="col-md-6 pt-2">
                                                        <strong>
                                                        <i class="fas fa-user-tag"></i> Roles
                                                        </strong>
                                                        <p class="text-muted ml-4">
                                                        <span v-for="(role, index) in roles" :key="index"  class="badge bg-primary mr-2 user-roles">{{ role.name }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user : user,
                userDetails : [],
                roles : []
            }
        },
        methods : {
            /*
            * Author: Iqbal
            * Date: 
            * Requirement: load User details
            */
            loadUser(id) {
                let route = window.routes.viewMyProfile;
                axios
                .get(route + id)
                .then(response => {
                    this.userDetails = response.data.data.user_details;
                    this.roles = response.data.data.roles;
                    // console.log(this.user.user_details.profile_image)
                })
                .catch(errors => {
                    console.log(errors);
                });
            }
        },
        created() {
            if (this.$route.params.id != 0) {
                this.loadUser(this.$route.params.id);
            }
        }
    }
</script>
