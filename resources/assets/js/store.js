import { getLocalUser } from "./helpers/auth";

const user = getLocalUser();

export default {
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        customers: [],
        inventory: [],
        walkins: [],
        inpatients: [],
        walkinOrder: [],
        patientOrder: [],
        additemPatient: [],
        consignor: [],
        walkinreports: [],
        inpatientsReport: [],
        doctor: [],
        tableDoctors: [],
        //invItem: []
    },
    getters: {
        isLoading(state) {
            return state.loading;
        },
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.auth_error;
        },
        customers(state) {
            return state.customers;
        },
        inventory(state) {
            return state.inventory;
        },
        walkins(state) {
            return state.walkins;
        },
        inpatients(state) {
            return state.inpatients;
        },
        walkinOrder(state) {
            return state.walkinOrder;
        },
        patientOrder(state) {
            return state.patientOrder;
        },
        // invItem(state) {
        //     return state.invItem;
        // },
        doctor(state) {
            return state.doctor;
        },
        tableDoctors(state) {
            return state.tableDoctors;
        },
        consignor(state) {
            return state.consignor;
        },
        additemPatient(state){
            return state.additemPatient;
        }
    },
    mutations: {
        login(state) {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});

            localStorage.setItem("user", JSON.stringify(state.currentUser));
        },
        loginFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout(state) {
            localStorage.removeItem("user");
            state.isLoggedIn = false;
            state.currentUser = null;
        },
        updateCustomers(state, payload) {
            state.customers = payload;
        },
        inventoryItems(state, payload) {
            state.inventory = payload;
        },
        patientWalkin(state, payload) {
            state.walkins = payload;
        },
        Inpatient(state, payload) {
            state.inpatients = payload;
        },
        walkinOrders(state, payload) {
            state.walkinOrder = payload;
        },
        patientOrders(state, payload) {
            state.patientOrder = payload;
        },
        // invItems(state, payload) {
        //     state.invItem = payload;
        // },
        selectconsignors(state, payload) {
            state.consignor = payload;
        },
        patientDoctor(state, payload) {
            state.doctor = payload;
        },
        gettableDoctor(state, payload) {
            state.tableDoctors = payload;
        },
        patientOrderselecteds(state, payload) {
            state.additemPatient = payload;
        },
        register(state) {
            state.loading = true;
            state.auth_error = false;
        },
        registerSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggedIn = false;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});

            localStorage.setItem("user", JSON.stringify(state.currentUser));
        },
        registerFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;
        },
    },
    actions: {
        login(context) {
            context.commit("login");
        },
        register(context) {
            context.commit("register");
        },
        getCustomers(context) {
            axios.get('/api/customers')
            .then((response) => {
                context.commit('updateCustomers', response.data.customers);
            })
        },
        getItems(context) {
            axios.get('/api/inventory')
            .then((response)=> {
                context.commit('inventoryItems', response.data.inventory);
            })
        },
        getWalkin(context) {
            axios.get('/api/pharmacy')
            .then((response)=> {
                context.commit('patientWalkin', response.data.walkins);
            })
        },
        getwalkinOrder(context) {
            axios.get('/api/pharmacy/newOrder')
                .then((response)=> {
                    context.commit('walkinOrders', response.data.walkinOrder);
            });
        },
        getwalkinOrderselected(context) {
            axios.post('/api/pharmacy/addItem')
                .then((response)=> {
                    context.commit('walkinOrderselecteds', response.data.additem);
            });
        },
        getinPatient(context) {
            axios.get('/api/inPatient')
            .then((response)=> {
                context.commit('Inpatient', response.data.inpatients);
            })
        },
        getpatientOrder(context) {
            axios.get('/api/inPatient/newOrder')
                .then((response)=> {
                    context.commit('patientOrders', response.data.patientOrder);
            });
        },
        // getItemInventory(context) {
        //     axios.get('/api/inventory/itemPick')
        //         .then((response)=> {
        //             context.commit('invItems', response.data.invItem);
        //     });
        // },
        getDoctor(context) {
            axios.get('/api/inPatient/pickDoctor')
                .then((response)=> {
                    context.commit('patientDoctor', response.data.doctor);
            });
        },
        pickConsignor(context) {
            axios.get('/api/inventory/pickconsignor')
            .then((response)=> {
                context.commit('selectconsignors', response.data.consignor);
            });
        },
        getpatientOrderselected(context) {
            axios.post('/api/inPatient/addItem')
                .then((response)=> {
                    context.commit('patientOrderselecteds', response.data.additemPatient);
            });
        },

    }
};