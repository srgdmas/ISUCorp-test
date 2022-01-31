<template>
    <q-layout
        view="lHh lpr lFf"
        class="shadow-2 rounded-borders "
        :class="$route.name === 'landing' || $route.name === 'login' || $route.name === 'register'?'':'bg-grey-3'"

    >
        <q-header elevated class=" text-white q-py-xs bgblue" height-hint="58">
            <q-toolbar>
                <q-btn
                    flat
                    dense
                    round
                    @click="leftDrawerOpen = !leftDrawerOpen"
                    aria-label="Menu"
                    icon="menu"

                />

                <q-btn flat no-caps no-wrap class="q-ml-xs" v-if="$q.screen.gt.xs" to="/">
                    <img v-if="$route.path !== '/'" src="/storage/logos/logo_negative.png"
                         @click="$router.push({ name: 'landing' })" alt="logo"
                         style="height: 5rem"/>

                </q-btn>


                <q-space/>

                <!--                <div class="q-gutter-sm row items-center no-wrap">-->


                <!--                <q-input v-model="filter"-->
                <!--                         label="Escriba algo para filtrar"-->
                <!--                         rounded outlined-->
                <!--                         dense-->
                <!--                         v-if="searching" bg-color="white">-->

                <!--                </q-input>-->
                <autocomplete :search="search"
                              v-if="accessToken !== null"
                              :get-result-value="item => item.fullname"
                              @submit="onSubmit"
                >
                    <template #result="{ result, props }">
                        <li v-bind="props" class="text-secondary">
                            <div class="wiki-title">
                                {{ result.fullname }}
                            </div>
                            <div class="wiki-snippet" v-html="result.snippet" />
                        </li>
                    </template>

                </autocomplete>
<!--                <q-input dark dense standout v-model="filter" input-class="text-right" class="q-ml-md">-->
<!--                    <template v-slot:append>-->
<!--                        <q-icon v-if="filter === ''" name="search"/>-->
<!--                        <q-icon v-else name="clear" class="cursor-pointer" @click="filter = ''"/>-->
<!--                    </template>-->
<!--                </q-input>-->

                <!--                <q-btn icon="search" flat color="white" @click="searching = true"/>-->

                <q-btn round dense flat color="white" icon="mdi-playlist-edit"
                       v-if="accessToken !== null && user.role === 2"
                       @click="newPay">
                    <q-tooltip>Generar cobro instantáneo</q-tooltip>
                </q-btn>
                <q-btn round dense flat color="white" icon="notifications" v-if="accessToken !== null">
                    <q-badge color="red" text-color="white" floating>
                        {{this.notifications.length}}
                    </q-badge>
                    <q-popup-proxy @hide="readNotify">
                        <q-banner v-for="(item,index) in notifications" :key="index">
                            <template v-slot:avatar>
                                <q-icon :name="getIcon(item.type)[0]" :color="getIcon(item.type)[1]"/>
                            </template>
                            {{item.description}}
                        </q-banner>
                    </q-popup-proxy>
                    <q-tooltip>Notificaciones</q-tooltip>
                </q-btn>

                <q-btn flat icon="mdi-login" v-if="accessToken === null && visible" to="/login">
                    <q-tooltip>Entrar</q-tooltip>
                </q-btn>
                <!--                </div>-->
            </q-toolbar>
        </q-header>

        <q-drawer
            v-model="leftDrawerOpen"
            bordered
            content-class="bg-secondary text-white"
            :width="340"
            style="padding-bottom: 1rem "
            class=""
        >
            <q-scroll-area class="fit menuList" >
                <div class="q-px-md text-center q-mt-md" v-if="accessToken !== null && user">
                    <img v-if="user.photo !== null" :src="`/storage/${user.photo}`" style="height:8rem"
                         class="nrounded"/>
                    <div class="text-h6" style="margin-top: -2rem">{{user.name}}
                        {{user.lastname !=='null'?user.lastname:''}}
                    </div>
                    <q-separator size="0.2rem" class="q-mt-md" color="white"/>
                </div>
                <q-list class="q-px-md q-pt-md mylist" dense id="this">

                    <q-item v-ripple clickable class="customItem" @click="$router.push('/')"
                            v-if="accessToken !== null && user && user.role !== 3"
                            :class="$route.path === '/'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Dashboard</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-home"/>
                        </q-item-section>
                    </q-item>
                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 1"
                            @click="$router.push('/clients')" :class="$route.path === '/clients'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Personas</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-account-box-multiple"/>
                        </q-item-section>
                    </q-item>

                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 2"
                            @click="$router.push('/users2')"
                            :class="$route.path === '/users2'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Personas</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-account-group"/>
                        </q-item-section>
                    </q-item>

                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 1"
                            @click="$router.push('/administrators')"
                            :class="$route.path === '/administrators'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Administradores</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-account-supervisor-outline"/>
                        </q-item-section>
                    </q-item>
                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 1" @click="$router.push('/companies')"
                            :class="$route.path === '/companies'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Compañías</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-office-building"/>
                        </q-item-section>
                    </q-item>
                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 2"
                            @click="$router.push('/services')"
                            :class="$route.path === '/services'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Productos/Servicios</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-tag"/>
                        </q-item-section>
                    </q-item>
                    <q-expansion-item
                        expand-separator
                        label="Ingresos"
                        header-class="text-white"
                        expand-icon-class="text-white"
                        v-if="accessToken !== null && user && user.role !== 3">
                        <q-card class="bg-secondary">
                            <q-card-section>
                                <q-list style="margin-left: -1rem; margin-right: -1rem">
                                    <q-item clickable v-ripple class="customItem" to="/income-hand"
                                            :class="$route.path === '/income-hand'? 'marked':''">
                                        <q-item-section>Crear factura rápida</q-item-section>
                                        <q-item-section avatar>
                                            <q-icon color="white" name="mdi-lead-pencil"/>
                                        </q-item-section>
                                    </q-item>
                                    <q-item v-ripple clickable class="customItem"
                                            v-if="accessToken !== null && user.role === 2"
                                            @click="newPay"
                                    >

                                        <q-item-section>
                                            <q-item-label style="color: white">Generar cobro instantáneo</q-item-label>
                                        </q-item-section>
                                        <q-item-section avatar>
                                            <q-icon color="white" name="mdi-playlist-edit"/>
                                        </q-item-section>
                                    </q-item>

                                    <q-item clickable v-ripple class="customItem" to="/income-recharges"
                                            :class="$route.path === '/income-recharges'? 'marked':''">
                                        <q-item-section>Recargas</q-item-section>
                                        <q-item-section avatar>
                                            <q-icon color="white" name="mdi-cash-100"/>
                                        </q-item-section>
                                    </q-item>
                                    <q-item clickable v-ripple class="customItem" to="/income-comissions"
                                            :class="$route.path === '/income-comissions'? 'marked':''">
                                        <q-item-section>Comisiones</q-item-section>
                                        <q-item-section avatar>
                                            <q-icon color="white" name="attach_money"/>
                                        </q-item-section>
                                    </q-item>
                                    <q-item clickable v-ripple class="customItem" to="/facturas"
                                            :class="$route.path === '/facturas'? 'marked':''">
                                        <q-item-section>Facturas</q-item-section>
                                        <q-item-section avatar>
                                            <q-icon color="white" name="mdi-clipboard-text"/>
                                        </q-item-section>
                                    </q-item>
                                </q-list>
                            </q-card-section>
                        </q-card>
                    </q-expansion-item>
                    <q-expansion-item
                        expand-separator
                        label="Gastos"
                        header-class="text-white"
                        expand-icon-class="text-white"

                        v-if="accessToken !== null && user && user.role !== 3">
                        <q-card class="bg-secondary">
                            <q-card-section>
                                <q-list style="margin-left: -1rem; margin-right: -1rem">
                                    <q-item clickable v-ripple class="customItem" to="/expensive-hand"
                                            :class="$route.path === '/expensive-hand'? 'marked':''">
                                        <q-item-section>Manuales</q-item-section>
                                        <q-item-section avatar>
                                            <q-icon color="white" name="mdi-lead-pencil"/>
                                        </q-item-section>
                                    </q-item>
                                    <q-item clickable v-ripple class="customItem" to="/expense-recharges"
                                            :class="$route.path === '/expense-recharges'? 'marked':''">
                                        <q-item-section>Recargas</q-item-section>
                                        <q-item-section avatar>
                                            <q-icon color="white" name="mdi-cash-100"/>
                                        </q-item-section>
                                    </q-item>
                                    <q-item clickable v-ripple class="customItem" to="/facturas-gastos"
                                            :class="$route.path === '/facturas-gastos'? 'marked':''">
                                        <q-item-section>Facturas</q-item-section>
                                        <q-item-section avatar>
                                            <q-icon color="white" name="mdi-clipboard-text"/>
                                        </q-item-section>
                                    </q-item>

                                </q-list>
                            </q-card-section>
                        </q-card>
                    </q-expansion-item>
                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 1"
                            @click="$router.push('/statics')" :class="$route.path === '/statics'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Estadísticas</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-chart-bar"/>
                        </q-item-section>
                    </q-item>
                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 1"
                            @click="$router.push('/balance')"
                            :class="$route.path === '/balance'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Balance</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-scale-balance"/>
                        </q-item-section>
                    </q-item>
                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 1"
                            @click="$router.push('/logs')"
                            :class="$route.path === '/logs'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Seguridad</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-format-list-text"/>
                        </q-item-section>
                    </q-item>

                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 1"
                            @click="$router.push('/taxes')"
                            :class="$route.path === '/taxes'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Tarifas y comisiones</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-table"/>
                        </q-item-section>
                    </q-item>
                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 1"
                            @click="$router.push('/recharges')"
                            :class="$route.path === '/recharges'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Recargas</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-cash-100"/>
                        </q-item-section>
                    </q-item>
                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 1"
                            @click="$router.push('/categories')"
                            :class="$route.path === '/categories'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Categorías</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-format-list-checkbox"/>
                        </q-item-section>
                    </q-item>
                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 1"
                            @click="$router.push('/configuration')"
                            :class="$route.path === '/configuration'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Configuración</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="settings"/>
                        </q-item-section>
                    </q-item>


                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 3"
                            @click="$router.push('/user-profile')"
                            :class="$route.path === '/user-profile'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Perfil de usuario</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-wallet"/>
                        </q-item-section>
                    </q-item>
                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 3"
                            @click="$router.push('/balance-client')"
                            :class="$route.path === '/balance-client'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Balance</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-scale-balance"/>
                        </q-item-section>
                    </q-item>
                    <!--Compannia-->

                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user.role === 3"
                            @click="$router.push('/instantant-pay')"
                            :class="$route.path === '/instantant-pay'? 'marked':''"
                    >
                        <q-item-section>
                            <q-item-label style="color: white">Pago Instantáneo</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-cart-arrow-right"/>
                        </q-item-section>
                    </q-item>
                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 2"
                            @click="$router.push('/balance')"
                            :class="$route.path === '/balance'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Balance</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-scale-balance"/>
                        </q-item-section>
                    </q-item>


                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 2"
                            @click="$router.push('/estadisticas')"
                            :class="$route.path === '/estadisticas'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Estadísticas</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-chart-bar"/>
                        </q-item-section>
                    </q-item>


                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 2"
                            @click="$router.push('/user-profile')"
                            :class="$route.path === '/user-profile'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Perfil de usuario</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-wallet"/>
                        </q-item-section>
                    </q-item>


                    <!--Amigos-->
                    <q-expansion-item
                        expand-separator
                        label="Amigos"
                        header-class="text-white"
                        expand-icon-class="text-white"
                        v-if="accessToken !== null && user && user.role === 3">
                        <q-card class="bg-secondary">
                            <q-card-section>
                                <q-list style="margin-left: -1rem; margin-right: -1rem">
                                    <q-item v-ripple clickable class="customItem"
                                            v-if="accessToken !== null && user && user.role === 3"
                                            @click="$router.push('/user-search')"
                                            :class="$route.path === '/user-search'? 'marked':''">
                                        <q-item-section>
                                            <q-item-label style="color: white">Buscar amigos</q-item-label>
                                        </q-item-section>
                                        <q-item-section avatar>
                                            <q-icon color="white" name="mdi-account-group-outline"/>
                                        </q-item-section>
                                    </q-item>
                                    <q-item v-ripple clickable class="customItem"
                                            v-if="accessToken !== null && user && user.role === 3"
                                            @click="$router.push('/friends-requests')"
                                            :class="$route.path === '/friends-requests'? 'marked':''">
                                        <q-item-section>
                                            <q-item-label style="color: white">Solicitudes de amistad</q-item-label>
                                        </q-item-section>
                                        <q-item-section avatar>
                                            <q-icon color="white" name="mdi-account-arrow-left"/>
                                        </q-item-section>
                                    </q-item>
                                    <q-item v-ripple clickable class="customItem"
                                            v-if="accessToken !== null && user && user.role === 3"
                                            @click="$router.push('/my-friends')"
                                            :class="$route.path === '/my-friends'? 'marked':''">
                                        <q-item-section>
                                            <q-item-label style="color: white">Amigos</q-item-label>
                                        </q-item-section>
                                        <q-item-section avatar>
                                            <q-icon color="white" name="mdi-account-multiple-outline"/>
                                        </q-item-section>
                                    </q-item>
                                </q-list>
                            </q-card-section>
                        </q-card>
                    </q-expansion-item>


                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 3"
                            @click="$router.push('/my-services')"
                            :class="$route.path === '/my-services'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Compañías</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-format-list-numbered-rtl"/>
                        </q-item-section>
                    </q-item>
                    <q-item v-ripple clickable class="customItem"
                            v-if="accessToken !== null && user && user.role === 3"
                            @click="$router.push('/network')"
                            :class="$route.path === '/network'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Red GMoney</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="mdi-vector-rectangle"/>
                        </q-item-section>
                    </q-item>


                    <q-item v-ripple clickable class="customItem"
                            @click="$router.push('/recover-password')"
                            :class="$route.path === '/recover-password'? 'marked':''"
                            v-if="accessToken === null"
                    >
                        <q-item-section>
                            <q-item-label style="color: white">Recuperar contraseña</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="undo"/>
                        </q-item-section>
                    </q-item>
                    <q-item v-ripple clickable class="customItem"
                            @click="$router.push('/help')"
                            :class="$route.path === '/help'? 'marked':''">
                        <q-item-section>
                            <q-item-label style="color: white">Ayuda</q-item-label>
                        </q-item-section>
                        <q-item-section avatar>
                            <q-icon color="white" name="help"/>
                        </q-item-section>
                    </q-item>


                    <q-item v-ripple clickable
                            v-if="accessToken !== null && visible"
                            @click="$router.push('/logout')"
                            class="customItem"
                    >

                        <q-item-section>
                            <q-item-label>Cerrar sesión</q-item-label>
                        </q-item-section>

                        <q-item-section avatar>
                            <q-icon color="white" name="logout"/>
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-scroll-area>
        </q-drawer>
        <q-page-container class="q-mt-lg">
            <q-scroll-area style="height: 49rem; ">
                <q-page>
                    <router-view/>
                </q-page>
            </q-scroll-area>
            <q-page-scroller
                position="bottom-right"
                :scroll-offset="150"
                :offset="[18, 18]"
            >
                <q-btn fab icon="keyboard_arrow_up" color="secondary"/>
            </q-page-scroller>
        </q-page-container>
        <q-footer elevated class=" myfooter" style="background: none">
            <div class="q-py-md q-px-md"
                 :class="$route.name === 'landing' || $route.name === 'login' || $route.name === 'register'?'text-white':'text-dark'">
                <div class="row q-gutter-md justify-between q-px-xl">
                    <div>@2020 GMoney | Todos los derechos revservados</div>
                    <div>
                        <a href="https://thecloud.group" title="Holding Internacional de Servicios" target="_blank"
                           :class="$route.name === 'landing' || $route.name === 'login' || $route.name === 'register'?'customLink':'customLink2'">
                            Desarrollado por
                            <b class="text-body2 text-bold">The Cloud Group</b>
                        </a>
                    </div>
                </div>
            </div>
        </q-footer>


        <q-dialog v-model="paying1">

            <q-card style="width: 800px; max-width: 80vw;">
                <q-bar style="height: 40px; background: #0073CE" class="text-white">
                    <div>Generar cobro instantáneo</div>
                </q-bar>
                <div class="row bordeado text-weight-bold" v-if="pedidos.length > 0">
                    <div class="col-1">No.</div>
                    <div class="col-4">Producto</div>
                    <div class="col-2">Precio</div>
                    <div class="col-2">Unidades</div>
                    <div class="col-2">Subtotal</div>
                    <div class="col">Cancelar</div>
                </div>
                <div class="row bordeado items-center " v-for="(item,index) in pedidos" :key="index">
                    <div class="col-1 q-py-sm">{{index+1}}</div>
                    <div class="col-4 q-py-sm">{{item.product.description}}</div>
                    <div class="col-2 q-py-sm">{{item.product.price}} CFA</div>
                    <div class="col-2 q-py-sm">{{item.amount}}</div>
                    <div class="col-2 q-py-sm">{{(item.amount * item.product.price).toFixed(2)}} CFA</div>
                    <div class="col q-py-sm">
                        <q-btn icon="close" rounded @click="deletePedido(index)" color="negative" size="xs"/>
                    </div>
                </div>
                <div class="row bordeado q-py-md text-weight-bold text-h6" v-if="pedidos.length > 0">
                    <div class="col q-py-sm">Total</div>
                    <div class="col-3  q-py-sm">{{parseFloat(total).toFixed(2)}} CFA</div>
                </div>
                <div class="row items-center q-mt-md q-px-md q-gutter-md">
                    <div class="col-7">
                        <q-select
                            v-model="pedido.product"
                            :options="data"
                            :option-label="item => item.description"
                            label="Producto"
                        />
                    </div>
                    <div class="col">
                        <q-input v-model="pedido.amount" label="Unidades" mask="#.##"
                                 fill-mask="0"
                                 outlined
                                 rounded
                                 reverse-fill-mask
                                 :rules="[$rules.maxValue(pedido.product?pedido.product.amount:0)]"
                        />
                    </div>
                    <div class="col-1">
                        <q-btn icon="add" @click="addPedido" color="secondary" size="sm" rounded
                               v-if="parseFloat(pedido.product.amount) >= parseFloat(pedido.amount)"/>
                    </div>
                </div>
                <div class="row text-center q-mt-md">
                    <div class="col q-py-md">
                        <q-btn label="Generar código QR de pago" color="green" @click="getPay"
                               v-if="pedidos.length > 0"
                               size="sm"
                               rounded
                               :loading="storing"/>
                        <q-btn label="Generar código numérico de pago" color="secondary" @click="getCode"
                               v-if="pedidos.length > 0"
                               size="sm"
                               rounded
                               :loading="storing"/>
                        <q-btn label="Cancelar" color="negative" @click="cancelPay" :loading="storing"
                               rounded
                               size="sm"
                               class="q-ml-md"/>
                    </div>
                </div>
            </q-card>
        </q-dialog>
        <q-dialog v-model="paying2" persistent>
            <q-card>
                <q-bar style="height: 40px; background: #0073CE" class="text-white">
                    <div>QR de pago</div>
                </q-bar>
                <div class="row q-gutter-md q-px-md q-pt-xl">
                    <div class="col-12 col-md text-center">
                        <qrcode-vue :value="string_qr" :size="200" level="H"></qrcode-vue>
                    </div>
                    <div class="col-12 col-md" style="height: 250px">
                        Pasos para ejecutar el pago
                        <q-list bordered>
                            <q-item clickable v-ripple>
                                <q-item-section avatar>
                                    <q-icon color="primary" name="mdi-numeric-1-box"/>
                                </q-item-section>

                                <q-item-section>El cliente abre en la aplicación la sección Pago por QR</q-item-section>
                            </q-item>
                            <q-item clickable v-ripple>
                                <q-item-section avatar>
                                    <q-icon color="primary" name="mdi-numeric-2-box"/>
                                </q-item-section>

                                <q-item-section>Escanear este código QR y confirmar pago</q-item-section>
                            </q-item>
                            <q-item clickable v-ripple>
                                <q-item-section avatar>
                                    <q-icon color="primary" name="mdi-numeric-3-box"/>
                                </q-item-section>

                                <q-item-section>Verificar pago</q-item-section>
                            </q-item>

                        </q-list>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col q-py-md">
                        <q-btn label="Verificar pago" color="primary" @click="execute_pay"
                               rounded
                               size="sm"
                               :loading="storing"/>
                        <q-btn label="Cerrar" color="negative" @click="paying2 = false" :loading="storing"
                               rounded
                               size="sm"
                        />
                    </div>
                </div>
            </q-card>
        </q-dialog>

        <q-dialog v-model="checking" v-if="bill !== ''">
            <q-card class="q-pa-md">
                <div class="row">
                    <div class="col-12 text-h5 text-center">
                        Pago Realizado
                    </div>
                    <div class="col-12 text-center">
                        El comercio ha recibido correctamente
                        tu pago, tu comprobante es: #{{bill.number}}
                    </div>
                    <div class="col-12 text-center text-h6">
                        Detalles
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col">Fecha</div>
                            <div class="col">{{formatDate2(bill.paid_at)}}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col">Cantidad</div>
                            <div class="col text-negative">{{bill.amount}} CFA</div>
                        </div>
                    </div>
                    <div class="col-12" v-if="bill.client">
                        <div class="row">
                            <div class="col">Pagador</div>
                            <div class="col">{{bill.client.user.name}}
                                {{bill.client.user.lastname}}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-h5">
                        Gracias por utilizar los servicios de GMoney
                    </div>
                    <div class="col-12 text-right q-mt-lg">
                        <q-btn icon="close" rounded color="grey" outline @click="checking = false"/>
                    </div>

                </div>
            </q-card>
        </q-dialog>
        <q-dialog v-model="checking2" v-if="bill !== ''">
            <q-card class="q-pa-md">
                <div class="row">
                    <div class="col-12 text-h5 text-center">
                        Factura generada
                    </div>
                    <div class="col-12 text-center text-h5 text-negative">
                        Código: {{bill.token}}
                    </div>
                    <div class="col-12 text-center text-h6">
                        Detalles
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col">Fecha</div>
                            <div class="col">{{formatDate2(bill.bill_date)}}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col">Cantidad</div>
                            <div class="col text-negative">{{bill.amount}} CFA</div>
                        </div>
                    </div>

                    <div class="col-12 text-h5">
                        Gracias por utilizar los servicios de GMoney
                    </div>
                    <div class="col-12  q-mt-lg">
                        <div class="row">
                            <div class="col">
                                <q-btn icon="email" rounded color="grey" outline @click="nemail = true"/>
                            </div>
                            <div class="col text-right">
                                <q-btn icon="close" rounded color="grey" outline @click="checking2 = false"/>

                            </div>
                        </div>
                    </div>

                </div>
            </q-card>
        </q-dialog>

        <q-dialog v-model="nemail">
            <q-card>
                <q-form @submit="onSubmitEmail">
                    <q-card-section class="q-pt-none">

                        <div class="row q-gutter-md q-mt-sm">
                            <div class="col">
                                <q-input label="Email*" v-model="email"
                                         :rules="[$rules.required(), $rules.email()]"
                                />
                            </div>
                        </div>

                    </q-card-section>

                    <q-card-actions align="right">
                        <q-btn label="Enviar por email" color="primary" type="submit" :loading="storing"/>
                        <q-btn label="Cancelar" color="warning" v-close-popup/>
                    </q-card-actions>
                </q-form>
            </q-card>
        </q-dialog>
    </q-layout>
</template>

<script>
    import {VueScrollProgressBar} from "@guillaumebriday/vue-scroll-progress-bar";
    import {mapGetters, mapState} from "vuex";
    import QrcodeVue from 'qrcode.vue'
    import {date} from 'quasar'
    import Autocomplete from '@trevoreyre/autocomplete-vue'
    import '@trevoreyre/autocomplete-vue/dist/style.css'

    export default {
        components: {VueScrollProgressBar, QrcodeVue, Autocomplete},
        data() {
            return {
                searching: false,
                filter: '',
                optionsFilter: [
                    // {id: 1, fullname: 'Alberto'},
                    // {id: 2, fullname: 'Alberto2'},
                ],

                paying1: false,
                paying2: false,
                storing: false,
                nemail: false,
                email: '',
                string_qr: '',
                pedidos: [],
                pedido: {
                    product: '',
                    amount: 0.00
                },
                total: 0,
                bill: '',
                checking: false,
                checking2: false,
                leftDrawerOpen: false,
                notifications: [],
                links1: [

                    {icon: 'mdi-home', text: 'Dashboard', to: '/', condition: 2},
                    {icon: 'mdi-office-building', text: 'Compañías', to: '/companies', condition: 1},
                    {icon: 'mdi-chart-bar', text: 'Estadísticas', to: '/statics', condition: 1},
                    {icon: 'mdi-account-box-multiple', text: 'Personas', to: '/clients', condition: 1},
                    {
                        icon: 'mdi-account-supervisor-outline',
                        text: 'Administradores',
                        to: '/administrators',
                        condition: 1
                    },
                    {icon: 'mdi-tag', text: 'Servicios', to: '/services', condition: 2},
                    {icon: 'mdi-account-group', text: 'Personas', to: '/users2', condition: 2},
                    {icon: 'mdi-scale-balance', text: 'Balance', to: '/balance', condition: 1},
                    // {icon: 'mdi-cash-100', text: 'Recargas', to: '/recharges', condition: 1},
                    {icon: 'mdi-scale-balance', text: 'Balance', to: '/balance', condition: 2},
                    {icon: 'mdi-scale-balance', text: 'Balance', to: '/balance-client', condition: 3},
                    {icon: 'mdi-format-list-checkbox', text: 'Categorías', to: '/categories', condition: 1},
                    {icon: 'mdi-table', text: 'Tarifas y comisiones', to: '/taxes', condition: 1},
                    {icon: 'settings', text: 'Configuración', to: '/configuration', condition: 1},
                    {icon: 'mdi-wallet', text: 'Perfil de usuario', to: '/user-profile', condition: 2},
                    {icon: 'mdi-wallet', text: 'Perfil de usuario', to: '/user-profile', condition: 3},

                    {icon: 'mdi-account-group-outline', text: 'Buscar amigos', to: '/user-search', condition: 3},
                    {
                        icon: 'mdi-account-arrow-left',
                        text: 'Solicitudes de amistad',
                        to: '/friends-requests',
                        condition: 3
                    },
                    {icon: 'mdi-account-multiple-outline', text: 'Amigos', to: '/my-friends', condition: 3},
                    {icon: 'mdi-format-list-numbered-rtl', text: 'Compañías', to: '/my-services', condition: 3},

                    {icon: 'mdi-vector-rectangle', text: 'Red GMoney', to: '/network', condition: true},
                    {icon: 'undo', text: 'Recuperar contraseña', to: '/recover-password', condition: true},
                    {icon: 'help', text: 'Ayuda', to: '/help', condition: true},
                ],
                data: []
            };
        },
        computed: {
            ...mapState(["accessToken", 'user_photo', 'user_name']),
            ...mapGetters(['userEmail', 'accessToken', 'user']),
            visible() {
                return this.$route.path !== '/login' && this.$route.path !== '/register'
            }
        },
        methods: {
            onSubmit(result) {
                // window.open(`${wikiUrl}/wiki/${encodeURI(result.title)}`)
                this.$router.push(`/client/${result.user.token}`)
            },
            search(input) {
                if (input.length < 1) {
                    return []
                }
                return this.optionsFilter.filter(item => {
                    return item.fullname.toLowerCase()
                        .startsWith(input.toLowerCase())
                })
            },
            onSubmitEmail() {
                this.storing = true;
                let obj = {
                    email: this.email,
                    token: this.bill.token,
                };
                this.$axios.post('/clients/send-bill-code', obj).then(response => {
                    if (response.data.code === 200) {
                        this.$notify.notify_p(response.data.content);
                        this.cancelPay();
                        this.nemail = false;
                        this.storing = false;
                    } else {
                        this.$notify.notify_n(response.data.content)
                    }
                    this.storing = false;
                }).catch(error => {
                    this.$notify.notify_n('Imposible realizar el pago en estos momentos. Contacte al administrador', error)
                });
            },
            newPay() {
                this.findServices();
                this.paying1 = true
            },
            deletePedido(index) {
                this.pedidos.splice(index, 1)
            },
            addPedido() {
                if (this.pedido.amount < 0.01) {
                    this.$notify.notify_n('Debe seleccionar una cantidad mayor de 0.01')
                } else {
                    let buscar = [];
                    if (this.pedidos.length > 0) {
                        buscar = this.pedidos.filter(item => item.product.id === this.pedido.product.id);
                    }
                    if (buscar.length > 0) {
                        let newObj = {
                            product: this.pedido.product,
                            amount: parseFloat(buscar[0].amount) + parseFloat(this.pedido.amount)
                        };
                        let index = this.pedidos.indexOf(buscar[0]);
                        this.pedidos.splice(index, 1, newObj)
                    } else {
                        this.pedidos.push(this.pedido);
                    }
                    this.total += parseFloat((parseFloat(this.pedido.amount).toFixed(2) * parseFloat(this.pedido.product.price).toFixed(2)).toFixed(2));
                    this.pedido = {
                        product: '',
                        amount: 0.00
                    }
                }
            },
            getPay() {
                this.paying2 = true;
                this.string_qr = this.idsProductsPay();
            },
            getCode() {
                this.string_qr = this.idsProductsPay();
                this.execute_payCode();
            },
            idsProductsPay() {
                let ids = this.pedidos.map(item => item.product.id);
                let amount = this.pedidos.map(item => item.amount);
                let services = JSON.stringify({ids: ids, amount: amount});
                let total = this.total;
                return `${services}***${total}`;
            },
            cancelPay() {
                this.pedidos = [];
                this.pedido =
                    {
                        product: '',
                        amount: 0.00
                    };
                this.total = 0;
                this.paying1 = false;
                this.paying2 = false;
            },
            formatDate2(data) {
                return date.formatDate(data, 'DD/MM/YYYY hh:mmA ')
            },
            execute_pay() {
                this.storing = true;
                let ids = this.pedidos.map(item => item.product.id);
                let amount = this.pedidos.map(item => item.amount);
                let obj = new FormData();
                obj.append('services', JSON.stringify({ids: ids, amount: amount}));
                obj.append('total', this.total);

                this.$axios.post('/clients/pay-bill-qr', obj, {'content-type': 'multipart/form-data'}).then(response => {
                    console.log(response.data)
                    if (response.data.code === 200) {
                        this.findServices();
                        this.$notify.notify_p('Pago completado');
                        this.bill = response.data.content;
                        this.cancelPay();
                        this.checking = true;
                    } else {
                        this.$notify.notify_n(response.data.content)
                    }
                    this.storing = false;
                }).catch(error => {
                    this.$notify.notify_n('Imposible realizar el pago en estos momentos. Contacte al administrador', error)
                });
            },
            execute_payCode() {
                this.storing = true;
                let ids = this.pedidos.map(item => item.product.id);
                let amount = this.pedidos.map(item => item.amount);
                let obj = new FormData();
                obj.append('services', JSON.stringify({ids: ids, amount: amount}));
                obj.append('total', this.total);
                obj.append('token', 1);

                this.$axios.post('/clients/pay-bill-qr', obj, {'content-type': 'multipart/form-data'}).then(response => {
                    console.log(response.data)
                    if (response.data.code === 200) {
                        this.findServices();
                        this.$notify.notify_p('Factura generada en espera de pago ');
                        this.bill = response.data.content;
                        this.cancelPay();
                        this.checking2 = true;
                    } else {
                        this.$notify.notify_n(response.data.content)
                    }
                    this.storing = false;
                }).catch(error => {
                    this.$notify.notify_n('Imposible realizar el pago en estos momentos. Contacte al administrador', error)
                });
            },
            readNotify() {
                this.$axios.post('notification/read-all').then(response => {
                    this.notifications = [];
                }).catch(error => {
                    console.log('error', error)
                })
            },
            getIcon(type) {
                switch (type) {
                    case 'friend_request':
                        return ['mdi-account-question', 'primary'];
                    case 'friend_accept':
                        return ['mdi-account-plus', 'primary'];
                    case 'client_new':
                        return ['mdi-hand-okay', 'primary'];
                    case 'role_new':
                        return ['mdi-account-multiple-plus', 'primary'];
                    case 'add_amount':
                        return ['mdi-wallet-plus', 'primary'];
                    case 'delete_amount':
                        return ['mdi-transfer-down', 'negative'];
                    case 'add_service':
                        return ['done', 'primary'];
                    case 'delete_service':
                        return ['clear', 'negative'];
                    case 'new_bill':
                        return ['mdi-format-list-bulleted', 'primary'];
                    default:
                        return ['mdi-alert', 'primary'];
                }
            },
            findServices() {
                this.$axios.post('/companies/my-services').then(response => {
                    this.data = response.data.content.filter(item => item.amount > 0);
                }).catch(error => {
                    console.log('fail', error)
                });
            },
            findClients(){
                this.$axios.post('/clients').then(response => {
                    console.log(response.data);
                    this.optionsFilter.concat(response.data);
                    this.findCompanies();
                }).catch(error => {
                    console.log(error)
                })
            },
            findCompanies(){
                this.$axios.post('/companies').then(response => {
                    console.log(response.data)
                    this.optionsFilter.concat(response.data);
                }).catch(error => {
                    console.log(error)
                })
            }

        },
        mounted() {
            if (this.accessToken) {
                this.findServices();
                this.findClients();

                setTimeout(() => {
                    this.$axios.post(`notification`, {token: this.accessToken}).then(response => {
                        this.notifications = response.data.content.notifications.filter(item => item.read_at === null);
                    }).catch(error => {
                        this.$store.dispatch('logoutUser');
                        this.$router.push('/login')
                    })
                }, 5000);

                this.$axios.post('/companies/bills').then(response => {
                    console.log('Creadas facturas. Esto hay que borrarlo')
                }).catch(error => {
                    console.log(error)
                })
            }

        }
    };
</script>
<style type="css">
    *:not(i) {
        font-family: 'montserratregular', serif !important;
    }

    .bgblue {
        background-image: linear-gradient(to top, #3F49C4, #39A1C6);
    }

    /*.bgextra {*/
    /*    background-image: url("/img/bg_user.png");*/
    /*    background-size: cover;*/
    /*    background-repeat: no-repeat;*/
    /*}*/

    .bb {
        border-bottom: 1px solid #ccc;
    }

    .marked {
        font-weight: bold;
        font-size: 18px;
        padding-bottom: 3px;
    }

    .myshadow {
        color: black;
    }

    .nrounded {
        border-radius: 50%;
    }

    .bordeado div {
        border-bottom: 1px solid #0073CE;
        /*border-top: 1px solid #0073CE;*/
        text-align: center;
    }

    .q-drawer-container {
        /*margin-top: -2rem;*/

    }

    .mylist .q-item {
        min-height: 28px !important;
        padding: 4px 16px !important;
    }

    .customItem {
        min-height: 28px !important;
        padding: 4px 16px !important;
    }

    .q-dialog__backdrop {
        opacity: 0.7 !important;
        background: black;
    }

    .myfooter {
        border-style: none;
        border-color: inherit;
        box-shadow: none !important;
    }

    .myfooter .q-layout__shadow::after {
        box-shadow: none !important;
    }

    .customLink {
        cursor: pointer;
        color: white;
        text-decoration: none;
    }

    .customLink2 {
        cursor: pointer;
        color: black;
        text-decoration: none;
    }

    #this .q-item__section .q-icon {
        color: white;
    }

    .mylist .q-item.q-router-link--active {
        color: white !important;
    }
    .autocomplete-input{
        /*background-color: var(--q-color-secondary);*/
        color: white;
    }
</style>
