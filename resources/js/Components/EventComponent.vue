<template>
  <div class="row">
    <div v-if="isLoading">Loading Events...</div>
    <div v-else>
        <div class="col-sm-9 card">
            <div class="card-header ">
                <h4 class="mt-0 header-title">Events</h4>
                <div class="float-right">
                  <a href="#" class="btn btn-sm btn-success " @click="saveRows"> Save Rows </a> &nbsp;
                  <!-- <a href="#" class="btn btn-sm btn-info pull-right" @click="addRows"> Add Row </a> &nbsp; -->
                </div>

                <div class="row">
                  <form class="form-inline">
                      Filter Events <select class="form-control form-inline" style="width: 240px;" v-model="filterItems.event"   required >
                          <option selected>Filter Event </option>
                          <option v-for="(filter, index ) in filterItems" v-bind:key="index" :value="filter.event">{{ filter.event }}</option>
                      </select>
                      
                      <button class="btn btn-info" @click="getEventList"> <i class="fa fa-search"  > </i> Filter Event</button>
                  </form>
                  
                </div>
            </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th> S.N </th>
                            <th> Title </th>
                            <th> Description</th>
                            <th> Start Date</th>
                            <th> End Date </th>
               
                            <th> Action </th>
                        </tr>
                        <tbody>

                      <!-- <tr v-for="(input, k) in inputs" :key="'compo'+k">
                          <td scope="row" class="trashIconContainer">
                              <i class="fa fa-trash" @click="deleteRow(k, input)"> Remove</i>
                          </td>
                          <td>
                              <input class="form-control" type="text" v-model="input.title" />
                               <div v-if="allErrors && allErrors[k+'.fiscal_year_name']" class="text-danger">
                                     {{ allErrors[k+'.fiscal_year_name'][0] }}
                              </div>
                          </td>
                          <td>
                            <input class="form-control" type="text" v-model="input.description" />
                             <div v-if="allErrors && allErrors[k+'.description']" class="text-danger">
                                   {{ allErrors[k+'.descriptions'][0] }}
                            </div>
                        </td>
                          <td>
                              <Datepicker v-model="input.start_date" />
                               <div v-if="allErrors && allErrors[k+'.fiscal_year_start']" class="text-danger">
                                     {{ allErrors[k+'.fiscal_year_start'][0] }}
                              </div>
                          </td>
                          <td>
                            <Datepicker v-model="input.end_date" />
                          </td>
                          <td>
                          </td>                          

                      </tr> -->

                      <tr>
                        <td></td>
                        <td>
                            <input class="form-control" type="text" v-model="inputs.title" />
                            <div v-if="allErrors && allErrors['title']" class="text-danger">
                                  {{ allErrors['title'][0] }}
                            </div>
                        </td>
                        <td>
                          <input class="form-control" type="text" v-model="inputs.description" />
                          <div v-if="allErrors && allErrors['description']" class="text-danger">
                                {{ allErrors['description'][0] }}
                          </div>
                      </td>
                        <td>
                            <Datepicker v-model="inputs.start_date" />
                            <div v-if="allErrors && allErrors['start_date']" class="text-danger">
                                  {{ allErrors['start_date'][0]}}
                            </div>
                        </td>
                        <td>
                          <Datepicker v-model="inputs.end_date" />
                          <div v-if="allErrors && allErrors['end_date']" class="text-danger">
                            {{ allErrors['end_date'][0] }}
                      </div>
                        </td>
                        <td>
                        </td>
                      </tr>

                          <tr v-for="(event,index) in items" :key="event.id">
                            <td> {{ index +1 }}</td>
                            <td> {{ event.title }}</td>
                            <td> {{ event.description }}</td>
                            <td> {{ event.start_date }}</td>
                            <td> {{ event.end_date }}</td>
                            <td> <a href="#" class="btn btn-sm btn-danger" @click="alertDisplay(index, event.id)" > Delete <font-awesome-icon icon="coffee" > </font-awesome-icon>
                               </a> </td>

                        </tr>
                        

                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>
</template>
<script>
import { EventList } from "../Api";
import { storeEvent } from "../Api";
import { deleteEvent } from "../Api";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
const config = {
    headers: {
                Accept : 'application/json',
            }
};
export default {
    name: "EventComponent",
    components: {
      Datepicker
    },
    data() {
      return {
        allErrors : null ,
        isEmpty: false,
        isLoading: true,
        fields: ["title", "description", "start_date", "end_date"],
        filterItems : [
          {
            event : 'Finished', 
          },
          {
            event : 'Last Week', 
          },
          {
            event : 'Comming Week', 
          },
          {
            event : 'Comming ', 
          }
        ],
        items: [
     
        ],
        inputs: 
        // [
          {
            title : '',
            description : '',
            start_date : '',
            end_date : '',
 
        }
      // ]
  
      };
    },
    created() {
      this.getEventList();

    },
    methods: {
      async getEventList(data) {
        let filterType = {
          date : this.filterItems.event
        }
        this.isLoading = true;
         axios.all([
            axios.get(EventList, {
                    params : filterType
                    
              },config)
              ])
            .then(axios.spread((...responses) => {
                console.log(responses[0].data.data)
                this.items = responses[0].data.data ;
              }
              ))
            .catch(error => {
                console.log(error)
              })
            .finally(() => this.isLoading = false)
      },
      saveRows () {
              axios
                .post(storeEvent, this.inputs)
                .then(response => {
                    this.inputs.splice(0,this.inputs.length)
                })
                .catch(error => {
                    console.log('error is', error.response.status);
                    if (error.response.status == 422){
                        this.allErrors = error.response.data.errors
                    }
                    if (error.response.status == 500){
                        this.$toasted.show('Somethings went wrongs',{
                        type : 'error',
                        theme: "outline",
                        duration : 5000
                    });
                    }
                })
                .finally(
                    () =>
                    this.getEventList()
                    // this.loading = false
                )
        },

        addRows ()
        {
            this.show_input = true,
            this.inputs.push({
                fiscal_year_name : '',
                fiscal_year_name_np : '',
                current_active : false,
                fiscal_year_start : '',
                fiscal_year_end : null ,
            });
        },

        removeInput (index, obj) {
            console.log(index);
            this.inputs.splice(index, 1);
        },
        deleteRow(index, invoice_product) {
            var idx = this.inputs.indexOf(invoice_product);
            console.log('delete row ',idx, index);
            if (idx > -1) {
                this.inputs.splice(idx, 1);
            }
        },
        deleteEventRemote(index, event_id) {
            console.log(index, event_id);
            this.loading = false
            axios
            .delete(deleteEvent+event_id)
            .then(response => {
            })
            .catch(error => {
                console.log(error)
            })
            .finally(() => this.loading = false)
            this.fiscalyears.splice(index, 1);
        },
        alertDisplay(index, event_id) {
        this.$swal({
          title: 'Are you sure to Delete Event?',
          text: 'You can\'t revert your Event',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes Delete Event!',
          cancelButtonText: 'No, Keep it!',
          showCloseButton: true,
          showLoaderOnConfirm: true
        }).then((result) => {
          if(result.value) {
            this.deleteEventRemote(index, event_id)
            this.$swal('Deleted', 'You successfully deleted this item', 'success')
          } else {
            this.$swal('Cancelled', 'You choose cancel, No Delete operation done', 'info')
          }
        })
      },
  
    },
  };
  
</script> 