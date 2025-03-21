import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';

const api = 'http://127.0.0.1:8000/api/';
Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    // User
    username : '',
    password: '',
    rePassword: '',
    firstName: '',
    lastName: '',
    email: '',


    // Login
    token : localStorage.getItem('token') || '',
    userId : localStorage.getItem('userId') || '',
    role: JSON.parse(localStorage.getItem('role')) || '',
    userdata :  JSON.parse(localStorage.getItem('userdata')) || '',

    // Filter
    DateRange:[],
    search:'',

    // message
    message:"",
    
    //  Work Orders
    WorkOrders: [],

    // Form 
    dialog : false,
    edit : false,
    Progress : false,
    WOid : 0,
    Note: '',
    NameProduct : '',
    NumberWO : '',
    duedate : '',
    qty : '', 
    selectedSatus : '',
    selectedOperator : '',
    Status : [
      {"name": 'Pending', 'id': 'Pending' },
      {"name": 'In Progress', 'id': 'Progress' },
      {"name": 'Completed', 'id': 'Completed' },
      {"name": 'Cancelled', 'id': 'Cancelled' },
    ],
    RekapWorkOrders : [],
    operators:[],
    currentStatus:'',
    ProgressWorkOrders : [],
    CompleteWorkOrders : []
  },
  mutations: {
    SET_OBJECT(state, v) {
      let name = v[0];
      let val = v[1];
      state[name] = val;
    },

    SET_OBJECTS(state, v) {
      let name = v[0];
      let val = v[1];
      for (let i = 0; i < name.length; i++) state[name[i]] = val[i];
    },
  },
  actions: {
    async searchProgress(context) {
      try {
        const response = await axios.get(api + 'work-order/getProgressData');
        context.commit("SET_OBJECT", ["ProgressWorkOrders",response.data]);
      } catch (error) {
        if (error.response) {
          console.error('Registration failed:', error.response.data);
        } else {
          console.error('Registration failed:', error.message);
        }
      }
    },
    async updateStatus(context) {
      try {
          const response = await axios.post(`${api}work-order-progress/update/${context.state.WOid}`, {
              status: context.state.selectedSatus,
              quantity: context.state.qty,
              notes: context.state.Note,
          },          {
            headers: {
              'Authorization': `Bearer ${context.state.token}`,
            }
          });
  
          context.commit("SET_OBJECT", ["message", response.data.message]);
          console.log('Update successful:', response.data);
      } catch (error) {
          if (error.response) {
              console.error('Update failed:', error.response.data);
          } else {
              console.error('Update failed:', error.message);
          }
      }
  },
  
    async register(context) {
      try {
        const response = await axios.post(api + 'register', {
          username: context.state.username, 
          password: context.state.password, 
          role_id: 2
        });
        context.commit("SET_OBJECT", ["message",response.data.message]);
        localStorage.setItem('auth_token', response.data.token);  
      } catch (error) {
        if (error.response) {
          console.error('Registration failed:', error.response.data);
        } else {
          console.error('Registration failed:', error.message);
        }
      }
    },
    async login(context) {
      try {
        const response = await axios.post(api + 'login', {
          username: context.state.username, 
          password: context.state.password, 
        });
        context.commit("SET_OBJECT", ["message",response.data.message]);
        localStorage.setItem('token', response.data.access_token);  
        localStorage.setItem('role', JSON.stringify(response.data.role));  
        localStorage.setItem('userdata', JSON.stringify(response.data.userdata));  
        localStorage.setItem('userId', response.data.user_id);  
        window.location.href = '/dashboard';  
      } catch (error) {
        if (error.response) {
          console.error('Registration failed:', error.response.data);
          context.commit("SET_OBJECT", ["message", error.response.data.message]);
          context.commit("SET_OBJECT", ["dialog", true]);
        } else {
          console.error('Registration failed:', error.message);
        }
      }
    },

    async logout(context) {
      try {
        const response = await axios.post(
          api + 'logout', 
          {}, 
          {
            headers: {
              'Authorization': `Bearer ${context.state.token}`,
            }
          }
        );
    
        context.commit("SET_OBJECT", ["message", response.data.message]);
  
        localStorage.removeItem('token');
        localStorage.removeItem('role');
        localStorage.removeItem('userdata');
        localStorage.removeItem('userId');
    
        context.commit("SET_OBJECT", ["token", null]);
    
        window.location.href = '/';  
    
      } catch (error) {
        if (error.response) {
          console.error('Logout failed:', error.response.data);
        } else {
          console.error('Logout failed:', error.message);
        }
      }
    },    
    


    async addWorkOrder(context) {
      try {
        const response = await axios.post(
          api + 'work-order/save', 
          {
            product_name: context.state.NameProduct, 
            quantity: context.state.qty, 
            due_date: context.state.duedate, 
            status: context.state.selectedSatus,
            assigned_operator_id: context.state.selectedOperator,
            id : context.state.WOid
          },
          
          {
            headers: {
              'Authorization': `Bearer ${context.state.token}`,
            }
          }
        );
        context.commit("SET_OBJECT", ["message", response.data.message]);
      } catch (error) {
        if (error.response) {
          console.error('Registration failed:', error.response.data);
        } else {
          console.error('Registration failed:', error.message);
        }
      }
    },    
    async deleteWorkOrder(context) {
      try {
        const response = await axios.post(
          api + 'work-order/delete', 
          {
            id : context.state.WOid
          },
          
          {
            headers: {
              'Authorization': `Bearer ${context.state.token}`,
            }
          }
        );
        context.commit("SET_OBJECT", ["message", response.data.message]);
      } catch (error) {
        if (error.response) {
          console.error('Registration failed:', error.response.data);
        } else {
          console.error('Registration failed:', error.message);
        }
      }
    },    
    async WorkOrder(context) {
      try {
        const response = await axios.get(api + 'work-orders', {
          headers: {
            'Authorization': `Bearer ${context.state.token}`,  
          }
        });
        context.commit("SET_OBJECT", ["WorkOrders",response.data]);
      } catch (error) {
        console.error('Failed to fetch work orders:', error.response);
      }
    },


    async SearchWorkOrder(context) {
      try {
        const params = {
          assigned_id: context.state.userId,  
        };
    
        const response = await axios.get(api + 'operator-work-orders', {
          params, 
          headers: {
            'Authorization': `Bearer ${context.state.token}`,
          },
        });
    
        context.commit("SET_OBJECT", ["WorkOrders", response.data]);
      } catch (error) {
        if (error.response) {
          console.error('Failed to fetch work orders:', error.response.data);
        } else {
          console.error('Error occurred:', error.message);
        }
      }
    },

    async SearchRekap(context) {
      try {
        const response = await axios.get(api + 'work-order/work-order-report', {
          headers: {
            'Authorization': `Bearer ${context.state.token}`,
          },
        });
    
        context.commit("SET_OBJECT", ["RekapWorkOrders", response.data]);
      } catch (error) {
        if (error.response) {
          console.error('Failed to fetch work orders:', error.response.data);
        } else {
          console.error('Error occurred:', error.message);
        }
      }
    },

    async SearchComplete(context) {
      try {
        const response = await axios.get(api + 'work-order/completed-status-per-user', {
          headers: {
            'Authorization': `Bearer ${context.state.token}`,
          },
        });
    
        context.commit("SET_OBJECT", ["CompleteWorkOrders", response.data]);
      } catch (error) {
        if (error.response) {
          console.error('Failed to fetch work orders:', error.response.data);
        } else {
          console.error('Error occurred:', error.message);
        }
      }
    },
    
    async SearchOperator(context) {
      try {
        const response = await axios.get(api + 'operators', {
          headers: {
            'Authorization': `Bearer ${context.state.token}`,  
          }
        });
        context.commit("SET_OBJECT", ["operators",response.data]);
      } catch (error) {
        console.error('Failed to fetch work orders:', error.response);
      }
    }
  },  
  modules: {
  }
})
