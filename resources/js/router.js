import Vue from "vue";
import VueRouter from "vue-router";
import store from "./boot/store";
import _layout from './layout/_layout'
import Landing from "./pages/dashboard/Landing";
import LegalPolicy from "./pages/LegalPolicy";
import ContactUs from "./pages/ContactUs";
import Users from "./pages/Users";
import Login from "./pages/security/Login";
import Logout from "./pages/security/Logout";
import Clients from "./pages/Clients";
import Companies from "./pages/Companies";
import CompanyDetail from "./pages/CompanyDetail";
import Categories from "./pages/Categories";
import UserSearch from "./pages/UserSearch";
import FriendsRequest from "./pages/FriendsRequest";
import MyFriends from "./pages/MyFriends";
import UserProfile from "./pages/UserProfile";
import RecoverPassword from "./pages/RecoverPassword";
import SetPassword from "./pages/SetPassword";
import Roles from "./pages/Roles";
import RolesDetail from "./pages/RolesDetail";
import Register from "./pages/Register";
import Services from "./pages/Services";
import ClientDetail from "./pages/ClientDetail";
import Help from "./pages/Help";
import Servicios from "./pages/Servicios";
import ServiciosCategory from "./pages/ServiciosCategory";
import Clients2 from "./pages/Clients2";
import Configuration from "./pages/Configuration";
import BillDetail from "./pages/BillDetail";
import Transfer2 from "./pages/Transfer2";
import Balance from "./pages/Balance";
import Balance3 from "./pages/Balance3";
import Network from "./pages/Network";
import Taxes from "./pages/Taxes";
import Statics from "./pages/Statics";
import Recharges from "./pages/Recharges";
import Administrators from "./pages/Administrators";
import Sells from "./pages/Sells";
import GastoManual from "./pages/GastoManual";
import IngresoManual from "./pages/IngresoManual";
import IngresosRecargas from "./pages/IngresosRecargas";
import GastosRecargas from "./pages/GastosRecargas";
import IngresosComisiones from "./pages/IngresosComisiones";
import PagoInstataneo from "./pages/PagoInstataneo";
import Logs from "./pages/Logs";
import StaticsCompany from "./pages/StaticsCompany";
import Bill from "./pages/Bill";
import BillGastos from "./pages/BillGastos";
import _layoutLogin from "./layout/_layoutLogin";


Vue.use(VueRouter);

let router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: "/",
            component: _layoutLogin,
            children: [
                {
                    path: 'login',
                    name: 'login',
                    component: Login
                }
            ]
        },
        {
            path: "/",
            component: _layout,
            children: [
                {
                    path: "",
                    name: "landing",
                    component: Landing
                },
                {
                    path: "/aviso-legal",
                    name: "legal_policy",
                    component: LegalPolicy
                },
                {
                    path: "/contacto",
                    name: "contact_us",
                    component: ContactUs
                },
                {
                    path: "/users",
                    name: "users",
                    component: Users
                }, {
                    path: "/users2",
                    name: "users2",
                    component: Clients2
                },
                {
                    path: "/logout",
                    name: "logout",
                    component: Logout
                },
                {
                    path: "/register",
                    name: "register",
                    component: Register
                },
                {
                    path: "/clients",
                    name: "clients",
                    component: Clients
                }, {
                    path: "/client/:id",
                    name: "client",
                    component: ClientDetail
                }, {
                    path: "/companies",
                    name: "companies",
                    component: Companies
                }, {
                    path: "/company/:id",
                    name: "company",
                    component: CompanyDetail
                }, {
                    path: "/categories",
                    name: "categories",
                    component: Categories
                }, {
                    path: "/user-search",
                    name: "user-search",
                    component: UserSearch
                }, {
                    path: "/friends-requests",
                    name: "friends-requests",
                    component: FriendsRequest
                },
                {
                    path: "/my-friends",
                    name: "my-friends",
                    component: MyFriends
                }, {
                    path: "/user-profile",
                    name: "user-profile",
                    component: UserProfile
                }, {
                    path: "/recover-password",
                    name: "recover-password",
                    component: RecoverPassword
                },
                {
                    path: "/set-password/:token",
                    name: "set-password",
                    component: SetPassword
                },
                {
                    path: "/roles",
                    name: "roles",
                    component: Roles
                }, {
                    path: "/role/:id",
                    name: "role_detail",
                    component: RolesDetail
                },
                {
                    path: "/services",
                    name: "services",
                    component: Services
                }, {
                    path: "/help",
                    name: "help",
                    component: Help
                }, {
                    path: "/my-services",
                    name: "my-services",
                    component: Servicios
                }, {
                    path: "/services-category/:id",
                    name: "services-category/:id",
                    component: ServiciosCategory
                }, {
                    path: "/configuration",
                    name: "configuration",
                    component: Configuration
                },
                {
                    path: "/transfer/:id",
                    name: "transfer/:id",
                    component: Transfer2
                }, {
                    path: "/pay-bill-code/:token",
                    name: "pay-bill-code/:token",
                    component: BillDetail
                }, {
                    path: "/balance",
                    name: "balance",
                    component: Balance
                }, {
                    path: "/balance-client",
                    name: "balance-client",
                    component: Balance3
                }, {
                    path: "/network",
                    name: "network",
                    component: Network
                }, {
                    path: "/taxes",
                    name: "taxes",
                    component: Taxes
                }, {
                    path: "/statics",
                    name: "statics",
                    component: Statics
                }, {
                    path: "/recharges",
                    name: "recharges",
                    component: Recharges
                }, {
                    path: "/administrators",
                    name: "administrators",
                    component: Administrators
                }, {
                    path: "/sells",
                    name: "sells",
                    component: Sells
                }, {
                    path: "/expensive-hand",
                    name: "expensive-hand",
                    component: GastoManual
                },
                {
                    path: "/income-hand",
                    name: "income-hand",
                    component: IngresoManual
                }, {
                    path: "/income-recharges",
                    name: "income-recharges",
                    component: IngresosRecargas
                }, {
                    path: "/expense-recharges",
                    name: "expense-recharges",
                    component: GastosRecargas
                }, {
                    path: "/income-comissions",
                    name: "income-comissions",
                    component: IngresosComisiones
                }, {
                    path: "/instantant-pay",
                    name: "instantant-pay",
                    component: PagoInstataneo
                }, {
                    path: "/logs",
                    name: "logs",
                    component: Logs
                }, {
                    path: "/estadisticas",
                    name: "estadisticas",
                    component: StaticsCompany
                }, {
                    path: "/facturas",
                    name: "facturas",
                    component: Bill
                }, {
                    path: "/facturas-gastos",
                    name: "facturas-gastos",
                    component: BillGastos
                },
            ]
        }


    ],
    scrollBehavior: to => {
        return {x: 0, y: 0};
    }
});
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.loggedIn) {
            next();
            return
        }
        next('/login')
    } else {
        next()
    }
});

export default router;
