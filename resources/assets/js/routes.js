import Home from './components/Home.vue';

import Login from './components/auth/Login.vue';

import Register from './components/auth/Register.vue';

import CustomersMain from './components/customers/Main.vue';
import CustomersList from './components/customers/List.vue';
import NewCustomer from './components/customers/New.vue';
import Customer from './components/customers/View.vue';

import ReportList from './components/report/List.vue';
import ReportMain from './components/report/Main.vue';

import InventoryList from './components/inventory/List.vue';
import InventoryNew from './components/inventory/New.vue';
import InventoryView from './components/inventory/View.vue';
import InventoryMain from './components/inventory/Main.vue';
import InventoryConsignor from './components/inventory/Consignor.vue';
import InventoryDelivery from './components/inventory/Delivery.vue';

import pharmacyMain from './components/pharmacy/Main.vue';
import pharmacyList from './components/pharmacy/List.vue';
import pharmacyNew from './components/pharmacy/New.vue';
import pharmacyView from './components/pharmacy/View.vue';
import pharmacyNewOrder from './components/pharmacy/New.vue';

import inPatientMain from './components/inPatient/Main.vue';
import inPatientList from './components/inPatient/List.vue';
import inPatientNew from './components/inPatient/New.vue';
// import inPatientView from './components/inPatient/View.vue';
import inPatientNewOrder from './components/inPatient/List.vue';
import inPatientNewDoctor from './components/inPatient/AddDoctor.vue';
import inPatientAdmission from './components/inPatient/Admission.vue';
import inPatientUpdate from './components/inPatient/UpdatePatient.vue';
import inPatientPersonalDetails from './components/inPatient/PersonalDetails.vue'; 
import inPatientCurrentRecord from './components/inPatient/CurrentRecord.vue';
import inPatientActiveOrder from './components/inPatient/ActiveOrder.vue';
import inPatientOtherCharges from './components/inPatient/OtherCharges.vue';
import inPatientHistory from './components/inPatient/PatientHistory.vue';
import inPatientOutHistory from './components/inPatient/OutPatient.vue';
import inPatientAddOrder from './components/inPatient/AddOrder.vue';


export const routes = [
    {
        path: '/',
        component: Home,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login',
        component: Login
    },
    {
        path:'/register',
        component: Register
    },
    {
        path: '/inventory',
        component: InventoryMain,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: InventoryList
            },
            {
                path: 'new',
                component: InventoryNew
            },
            {
                path: 'consignor',
                component: InventoryConsignor
            },
            {
                path: 'delivery',
                component: InventoryDelivery
            },
            {
                path: ':itemcode',
                component: InventoryView
            }
        ]
    },
    {
        path: '/pharmacy',
        component: pharmacyMain,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: pharmacyList
            },
            {
                path: 'new',
                component: pharmacyNew
            },
            {
                path: ':id',
                component: pharmacyView
            },
            {
                path: 'newOrder',
                component: pharmacyNewOrder
            }
        ]
    },
    {
        path: '/inPatient',
        component: inPatientMain,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: inPatientList
            },
            {
                path: 'new',
                component: inPatientNew
            },
            {
                path: 'newdoctor',
                component: inPatientNewDoctor
            },
            {
                path: 'admission',
                component: inPatientAdmission
            },
            {
                path: 'newOrder',
                component: inPatientNewOrder
            },
            {
                path: ':inpatient_id',
                component: inPatientUpdate,
                children: [
                    {
                        path: 'personal',
                        name: 'personal-details',
                        component: inPatientPersonalDetails
                    },
                    {
                        path: 'current',
                        name: 'current-record',
                        component: inPatientCurrentRecord
                    },
                    {
                        path: 'order',
                        name: 'active-order',
                        component: inPatientActiveOrder
                    },
                    {
                        path: 'addOrder',
                        name: 'add-order',
                        component: inPatientAddOrder
                    },
                    {
                        path: 'other',
                        name: 'other-charges',
                        component: inPatientOtherCharges
                    },
                    {
                        path: 'history',
                        name: 'patient-history',
                        component: inPatientHistory
                    },
                    {
                        path: 'out-patient-history',
                        name: 'out-patient-history',
                        component: inPatientOutHistory
                    }
                ]
            }
            
        ]
    },
    {
        path: '/customers',
        component: CustomersMain,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: CustomersList
            },
            {
                path: 'new',
                component: NewCustomer
            },
            {
                path: ':id',
                component: Customer
            }
        ]
    },
    {
        path: '/report',
        component: ReportMain,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: ReportList
            }
        ]
    }
];
