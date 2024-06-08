<template>
    <nav>
        <div class="top">
            <router-link class="page-link" to="/">
                <div class="logo-container">
                    <img src="@/imgs/choyas/peu-choya.png" alt="Logo of Peu Research Center" title="Logo of Peu Research Center of a green pinata choya wearing a commander tag">
                </div>
            </router-link>

            <!-- <div class="credits">
                <p>Created by: Peureki.3647</p>
            </div> -->

            <!-- 
                * SHORTCUTS
                *
                * Settings | Dark/Light mode | Nav | Discord | Other
            -->

            <div class="shortcuts">
                <div class="left">
                    <!-- COG  -->
                    <svg
                        v-if="settingsToggle"
                        @click="changeSettingsToggle"
                        width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg"
                        id="cog"
                    >
                        <path d="M10.5 14.146C9.53308 14.146 8.60575 13.7619 7.92202 13.0782C7.2383 12.3944 6.85418 11.4671 6.85418 10.5002C6.85418 9.53323 7.2383 8.6059 7.92202 7.92217C8.60575 7.23845 9.53308 6.85433 10.5 6.85433C11.467 6.85433 12.3943 7.23845 13.078 7.92217C13.7617 8.6059 14.1458 9.53323 14.1458 10.5002C14.1458 11.4671 13.7617 12.3944 13.078 13.0782C12.3943 13.7619 11.467 14.146 10.5 14.146ZM18.2396 11.5106C18.2813 11.1772 18.3125 10.8439 18.3125 10.5002C18.3125 10.1564 18.2813 9.81267 18.2396 9.4585L20.4375 7.76058C20.6354 7.60433 20.6875 7.32308 20.5625 7.09391L18.4792 3.48975C18.3542 3.26058 18.0729 3.16683 17.8438 3.26058L15.25 4.30225C14.7083 3.896 14.1458 3.54183 13.4896 3.28142L13.1042 0.520998C13.083 0.398308 13.0191 0.287068 12.9238 0.206989C12.8285 0.126911 12.7079 0.083163 12.5833 0.083498H8.41668C8.15627 0.083498 7.93752 0.270998 7.89585 0.520998L7.51043 3.28142C6.85418 3.54183 6.29168 3.896 5.75002 4.30225L3.15627 3.26058C2.9271 3.16683 2.64585 3.26058 2.52085 3.48975L0.437516 7.09391C0.302099 7.32308 0.364599 7.60433 0.562516 7.76058L2.76043 9.4585C2.71877 9.81267 2.68752 10.1564 2.68752 10.5002C2.68752 10.8439 2.71877 11.1772 2.76043 11.5106L0.562516 13.2397C0.364599 13.396 0.302099 13.6772 0.437516 13.9064L2.52085 17.5106C2.64585 17.7397 2.9271 17.8231 3.15627 17.7397L5.75002 16.6877C6.29168 17.1043 6.85418 17.4585 7.51043 17.7189L7.89585 20.4793C7.93752 20.7293 8.15627 20.9168 8.41668 20.9168H12.5833C12.8438 20.9168 13.0625 20.7293 13.1042 20.4793L13.4896 17.7189C14.1458 17.4481 14.7083 17.1043 15.25 16.6877L17.8438 17.7397C18.0729 17.8231 18.3542 17.7397 18.4792 17.5106L20.5625 13.9064C20.6875 13.6772 20.6354 13.396 20.4375 13.2397L18.2396 11.5106Z" fill="#FFD12C"/>
                        <title>Toggle Settings</title>
                    </svg>

                    <svg
                        v-if="!settingsToggle"
                        @click="changeSettingsToggle"
                        width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg"
                        id="cog"
                    >
                        <path 
                            d="M10.5 14.146C9.53308 14.146 8.60575 13.7619 7.92202 13.0782C7.2383 12.3944 6.85418 11.4671 6.85418 10.5002C6.85418 9.53323 7.2383 8.6059 7.92202 7.92217C8.60575 7.23845 9.53308 6.85433 10.5 6.85433C11.467 6.85433 12.3943 7.23845 13.078 7.92217C13.7617 8.6059 14.1458 9.53323 14.1458 10.5002C14.1458 11.4671 13.7617 12.3944 13.078 13.0782C12.3943 13.7619 11.467 14.146 10.5 14.146ZM18.2396 11.5106C18.2813 11.1772 18.3125 10.8439 18.3125 10.5002C18.3125 10.1564 18.2813 9.81267 18.2396 9.4585L20.4375 7.76058C20.6354 7.60433 20.6875 7.32308 20.5625 7.09391L18.4792 3.48975C18.3542 3.26058 18.0729 3.16683 17.8438 3.26058L15.25 4.30225C14.7083 3.896 14.1458 3.54183 13.4896 3.28142L13.1042 0.520998C13.083 0.398308 13.0191 0.287068 12.9238 0.206989C12.8285 0.126911 12.7079 0.083163 12.5833 0.083498H8.41668C8.15627 0.083498 7.93752 0.270998 7.89585 0.520998L7.51043 3.28142C6.85418 3.54183 6.29168 3.896 5.75002 4.30225L3.15627 3.26058C2.9271 3.16683 2.64585 3.26058 2.52085 3.48975L0.437516 7.09391C0.302099 7.32308 0.364599 7.60433 0.562516 7.76058L2.76043 9.4585C2.71877 9.81267 2.68752 10.1564 2.68752 10.5002C2.68752 10.8439 2.71877 11.1772 2.76043 11.5106L0.562516 13.2397C0.364599 13.396 0.302099 13.6772 0.437516 13.9064L2.52085 17.5106C2.64585 17.7397 2.9271 17.8231 3.15627 17.7397L5.75002 16.6877C6.29168 17.1043 6.85418 17.4585 7.51043 17.7189L7.89585 20.4793C7.93752 20.7293 8.15627 20.9168 8.41668 20.9168H12.5833C12.8438 20.9168 13.0625 20.7293 13.1042 20.4793L13.4896 17.7189C14.1458 17.4481 14.7083 17.1043 15.25 16.6877L17.8438 17.7397C18.0729 17.8231 18.3542 17.7397 18.4792 17.5106L20.5625 13.9064C20.6875 13.6772 20.6354 13.396 20.4375 13.2397L18.2396 11.5106Z" 
                            fill="none" stroke="#FFD12C" stroke-width="2"
                        />
                        <title>Toggle Settings</title>
                    </svg>

                    <!-- FILTER -->
                    <svg 
                        v-if="filtersToggle"
                        @click="changeFiltersToggle"
                        width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.0001 9V16.88C10.0401 17.18 9.94013 17.5 9.71013 17.71C9.61762 17.8027 9.50773 17.8763 9.38675 17.9264C9.26578 17.9766 9.1361 18.0024 9.00513 18.0024C8.87416 18.0024 8.74448 17.9766 8.62351 17.9264C8.50253 17.8763 8.39264 17.8027 8.30013 17.71L6.29013 15.7C6.18107 15.5934 6.09814 15.463 6.04783 15.319C5.99752 15.175 5.9812 15.0213 6.00013 14.87V9H5.97013L0.210131 1.62C0.0477393 1.41153 -0.0255351 1.14726 0.00631899 0.88493C0.0381731 0.622602 0.172566 0.383546 0.380131 0.22C0.570131 0.08 0.780131 0 1.00013 0H15.0001C15.2201 0 15.4301 0.08 15.6201 0.22C15.8277 0.383546 15.9621 0.622602 15.9939 0.88493C16.0258 1.14726 15.9525 1.41153 15.7901 1.62L10.0301 9H10.0001Z" fill="#FFD12C"/>
                    </svg>

                    <svg 
                        v-if="!filtersToggle"
                        @click="changeFiltersToggle"
                        width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path 
                            d="M10.0001 9V16.88C10.0401 17.18 9.94013 17.5 9.71013 17.71C9.61762 17.8027 9.50773 17.8763 9.38675 17.9264C9.26578 17.9766 9.1361 18.0024 9.00513 18.0024C8.87416 18.0024 8.74448 17.9766 8.62351 17.9264C8.50253 17.8763 8.39264 17.8027 8.30013 17.71L6.29013 15.7C6.18107 15.5934 6.09814 15.463 6.04783 15.319C5.99752 15.175 5.9812 15.0213 6.00013 14.87V9H5.97013L0.210131 1.62C0.0477393 1.41153 -0.0255351 1.14726 0.00631899 0.88493C0.0381731 0.622602 0.172566 0.383546 0.380131 0.22C0.570131 0.08 0.780131 0 1.00013 0H15.0001C15.2201 0 15.4301 0.08 15.6201 0.22C15.8277 0.383546 15.9621 0.622602 15.9939 0.88493C16.0258 1.14726 15.9525 1.41153 15.7901 1.62L10.0301 9H10.0001Z" 
                            fill="none" stroke="#FFD12C" stroke-width="2"
                        />
                    </svg>

                    <!-- BOOKMARKS -->
                    <svg 
                        v-if="bookmarksToggle"
                        @click="changeBookmarksToggle"
                        width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 18V0H14V18L7 15L0 18Z" fill="#FFD12C"/>
                        <title>Bookmarks</title>
                    </svg>
                    <svg 
                        v-if="!bookmarksToggle"
                        @click="changeBookmarksToggle"
                        width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M1 16.4835V1H13V16.4835L7.39392 14.0809L7 13.912L6.60608 14.0809L1 16.4835Z" stroke="#FFD12C" stroke-width="2"/>
                        <title>Bookmarks</title>
                    </svg>
                </div>
                <div class="middle">
                    <!-- HAMBURGER -->
                    <svg 
                        @click="scrollTo('nav')"
                        width="25" height="17" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.85938C0 1.54857 0.123465 1.2505 0.343234 1.03073C0.563003 0.810965 0.861074 0.6875 1.17188 0.6875H23.8281C24.1389 0.6875 24.437 0.810965 24.6568 1.03073C24.8765 1.2505 25 1.54857 25 1.85938C25 2.17018 24.8765 2.46825 24.6568 2.68802C24.437 2.90779 24.1389 3.03125 23.8281 3.03125H1.17188C0.861074 3.03125 0.563003 2.90779 0.343234 2.68802C0.123465 2.46825 0 2.17018 0 1.85938ZM0 8.5C0 8.1892 0.123465 7.89113 0.343234 7.67136C0.563003 7.45159 0.861074 7.32812 1.17188 7.32812H23.8281C24.1389 7.32812 24.437 7.45159 24.6568 7.67136C24.8765 7.89113 25 8.1892 25 8.5C25 8.8108 24.8765 9.10887 24.6568 9.32864C24.437 9.54841 24.1389 9.67188 23.8281 9.67188H1.17188C0.861074 9.67188 0.563003 9.54841 0.343234 9.32864C0.123465 9.10887 0 8.8108 0 8.5ZM1.17188 13.9688C0.861074 13.9688 0.563003 14.0922 0.343234 14.312C0.123465 14.5318 0 14.8298 0 15.1406C0 15.4514 0.123465 15.7495 0.343234 15.9693C0.563003 16.189 0.861074 16.3125 1.17188 16.3125H23.8281C24.1389 16.3125 24.437 16.189 24.6568 15.9693C24.8765 15.7495 25 15.4514 25 15.1406C25 14.8298 24.8765 14.5318 24.6568 14.312C24.437 14.0922 24.1389 13.9688 23.8281 13.9688H1.17188Z" fill="#FFD12C"/>
                        <title>Redirect to navigation</title>
                    </svg>
                </div>

                <div class="right">
                    <!-- USER LOGIN -->
                    <svg 
                        @click="loginToggle = !loginToggle"
                        width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15 8C15 9.06087 14.5786 10.0783 13.8284 10.8284C13.0783 11.5786 12.0609 12 11 12C9.93913 12 8.92172 11.5786 8.17157 10.8284C7.42143 10.0783 7 9.06087 7 8C7 6.93913 7.42143 5.92172 8.17157 5.17157C8.92172 4.42143 9.93913 4 11 4C12.0609 4 13.0783 4.42143 13.8284 5.17157C14.5786 5.92172 15 6.93913 15 8ZM13 8C13 8.53043 12.7893 9.03914 12.4142 9.41421C12.0391 9.78929 11.5304 10 11 10C10.4696 10 9.96086 9.78929 9.58579 9.41421C9.21071 9.03914 9 8.53043 9 8C9 7.46957 9.21071 6.96086 9.58579 6.58579C9.96086 6.21071 10.4696 6 11 6C11.5304 6 12.0391 6.21071 12.4142 6.58579C12.7893 6.96086 13 7.46957 13 8Z" fill="#FFD12C"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11 0C4.925 0 0 4.925 0 11C0 17.075 4.925 22 11 22C17.075 22 22 17.075 22 11C22 4.925 17.075 0 11 0ZM2 11C2 13.09 2.713 15.014 3.908 16.542C4.74723 15.4399 5.8299 14.5467 7.07143 13.9323C8.31297 13.3179 9.67974 12.9988 11.065 13C12.4323 12.9987 13.7819 13.3095 15.0109 13.9088C16.2399 14.508 17.316 15.3799 18.157 16.458C19.0234 15.3216 19.6068 13.9952 19.8589 12.5886C20.111 11.182 20.0244 9.73553 19.6065 8.36898C19.1886 7.00243 18.4512 5.75505 17.4555 4.73004C16.4598 3.70503 15.2343 2.93186 13.8804 2.47451C12.5265 2.01716 11.0832 1.88877 9.66986 2.09997C8.25652 2.31117 6.91379 2.85589 5.75277 3.68905C4.59175 4.52222 3.64581 5.61987 2.99323 6.8912C2.34065 8.16252 2.00018 9.57097 2 11ZM11 20C8.93395 20.0031 6.93027 19.2923 5.328 17.988C5.97293 17.0647 6.83134 16.3109 7.83019 15.7907C8.82905 15.2705 9.93879 14.9992 11.065 15C12.1772 14.9991 13.2735 15.2636 14.2629 15.7714C15.2524 16.2793 16.1064 17.0159 16.754 17.92C15.1393 19.2667 13.1026 20.0029 11 20Z" fill="#FFD12C"/>
                    </svg>

                    <!-- DISCORD  -->
                    <svg 
                        @click="apiKeyToggle = !apiKeyToggle"
                        width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20 6.293C20 9.769 17.17 12.587 13.68 12.587C13.044 12.587 11.594 12.441 10.889 11.855L10.007 12.733C9.48796 13.25 9.62796 13.402 9.85896 13.652C9.95496 13.757 10.067 13.878 10.154 14.051C10.154 14.051 10.889 15.075 10.154 16.1C9.71296 16.685 8.47796 17.504 7.06796 16.1L6.77396 16.392C6.77396 16.392 7.65496 17.417 6.92096 18.442C6.47996 19.027 5.30396 19.612 4.27496 18.588L3.24696 19.612C2.54096 20.315 1.67896 19.905 1.33696 19.612L0.453957 18.734C-0.369043 17.914 0.110957 17.026 0.453957 16.684L8.09596 9.074C8.09596 9.074 7.36096 7.904 7.36096 6.294C7.36096 2.818 10.191 0 13.681 0C17.171 0 20 2.818 20 6.293ZM13.681 8.489C14.2643 8.49006 14.8241 8.25943 15.2374 7.84782C15.6507 7.4362 15.8836 6.8773 15.885 6.294C15.8844 6.00509 15.827 5.71912 15.716 5.4524C15.6049 5.18568 15.4424 4.94345 15.2378 4.73954C15.0331 4.53562 14.7903 4.37401 14.5232 4.26393C14.256 4.15386 13.9699 4.09747 13.681 4.098C13.392 4.09747 13.1059 4.15386 12.8387 4.26393C12.5716 4.37401 12.3288 4.53562 12.1241 4.73954C11.9195 4.94345 11.757 5.18568 11.646 5.4524C11.5349 5.71912 11.4775 6.00509 11.477 6.294C11.4783 6.8773 11.7112 7.4362 12.1245 7.84782C12.5378 8.25943 13.0977 8.49006 13.681 8.489Z" fill="#FFD12C"/>
                        <title>Enter API Key</title>
                    </svg>
                    <!-- MODAL  -->
                    <svg 
                        @click="nodeTrackerModalToggle = !nodeTrackerModalToggle; scrollTo('page-header');"
                        width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M0.125 0.125H8.45833V8.45833H0.125V0.125ZM10.5417 0.125H18.875V8.45833H10.5417V0.125ZM0.125 10.5417H8.45833V18.875H0.125V10.5417ZM13.6667 10.5417H15.75V13.6667H18.875V15.75H15.75V18.875H13.6667V15.75H10.5417V13.6667H13.6667V10.5417ZM12.625 2.20833V6.375H16.7917V2.20833H12.625ZM2.20833 2.20833V6.375H6.375V2.20833H2.20833ZM2.20833 12.625V16.7917H6.375V12.625H2.20833Z" fill="#FFD12C"/>
                        <title>Node Tracker Modal</title>
                    </svg>
                </div>
            </div>
        </div>

        <!--
            *
            *   "HELLO" MESSAGE TO USERS IF THEY ARE LOGGED IN
            *
        -->
        <Transition name="fade-right">
            <div v-if="user">
                <p>Welcome {{ user.name }}</p>
            </div>
        </Transition>
        <!--
            * SLOT - TIMERS
            * 
            * This changes depending on what timer page the website is currently on
        -->
        <slot name="timer"></slot>

        <!--
            * 
            * SETTINGS / OPTIONS
            *
        -->
        <Transition name="fade-right">
            <section v-if="settingsToggle">
                <article class="shortcut-container">
                    <h3>Settings</h3>
                    <div class="settings-button-container">
                        <!-- 
                            * SETTING BUTTONS
                            *
                            * BUY ORDER
                            * Change the properties of the button depending on the buy/sell order settings
                        -->
                        <p>Buy Order </p>
                            <div class="settings-button">
                            <button
                                @click="changeOrder('buy order')"
                                :class="buyOrderSetting == 'buy_price' ? 'active-button' : 'inactive-button'"
                            >
                                Buy Price
                            </button>
                            <button
                                @click="changeOrder('buy order')"
                                :class="buyOrderSetting == 'sell_price' ? 'active-button' : 'inactive-button'"
                            >
                                Sell Price
                            </button>
                        </div>
                    </div>

                    <div class="settings-button-container">
                        <!-- 
                            * SETTING BUTTONS
                            *
                            * SELL ORDER
                            * Change the properties of the button depending on the buy/sell order settings
                        -->
                        <p>Sell Order </p>
                            <div class="settings-button">
                                <button
                                @click="changeOrder('sell order')"
                                :class="sellOrderSetting == 'buy_price' ? 'active-button' : 'inactive-button'"
                            >
                                Buy Price
                            </button>
                            <button
                                @click="changeOrder('sell order')"
                                :class="sellOrderSetting == 'sell_price' ? 'active-button' : 'inactive-button'"
                            >
                                Sell Price
                            </button>
                        </div>
                    </div>
                    <!-- 
                            * 
                            * TAX SETTINGS
                            *
                        -->
                    <div class="settings-button-container">
                        <label for="tax">Tax</label>
                        <span class="settings-tax-input">
                            <input type="number" step="0.01" id="tax" name="tax" v-model="taxSetting">
                            <span class="settings-tax-model">
                                <svg 
                                    :style="{transform: `rotate(${taxSetting < 1 ? 90 : -90}deg)`}"
                                    width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path 
                                        :fill="taxSetting < 1 ? 'var(--color-down)' : 'var(--color-up)'"
                                        d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z"
                                    />
                                </svg>
                                <p>{{ convertTaxToPercent(taxSetting) }}</p>
                            </span>
                        </span>
                        
                    </div>

                    <div class="settings-button-container">
                        <button 
                            @click="handlePageRefresh()"    
                            class="submit"
                        >
                            Refresh
                        </button>
                    </div>
                    
                </article>
            
            </section>
        </Transition>

        <!--
            * SLOT - FILTERS
            * 
            * This changes depending on what page the website is currently on
        -->
        <Transition name="fade-right">
            <slot 
                v-if="filtersToggle"
                name="filters"
            ></slot>
        </Transition>

        <!--
            * SLOT - BOOKMARKS
            * 
            * This changes depending on what page the website is currently on
        -->
        <Transition name="fade-right">
            <slot 
                v-if="bookmarksToggle"
                name="bookmarks"
            ></slot>
        </Transition>

        <!-- 
            *
            * LOGIN CONTAINER
            * Users will be able to login or logout 
            * Username
            * Email
            * Password
        -->

        <Transition name="fade-right">
            <div class="form-container" v-if="loginToggle">
                <form @submit.prevent="login">
                    <label for="name">Username</label>
                    <input type="text" name="name" id="name" v-model="name">

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" v-model="email">

                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" v-model="password">

                    <span class="remember-container">
                        <label for="remember">Remember Me</label>
                        <input type="checkbox" name="remember" v-model="remember">
                    </span>
                    

                    <div class="form-button-container">
                        <button type="submit">Login</button>
                        
                        <button type="button" @click="logout">Logout</button>

                        <button type="button" @click="register">Register</button>
                    </div>
                </form>
            </div>
        </Transition>
        <!--
            *
            * ENTER API KEY CONTAINER
            *
        -->
        <Transition name="fade-right">
            <div class="form-container"  v-if="apiKeyToggle">
                <form @submit.prevent="enterAPIKey">
                    <label for="apiKey">Enter API Key</label>
                    <input type="text" name="apiKey" v-model="apiKey">

                    <button type="submit">Submit</button>
                </form>

                <button v-if="user" @click="getWizardsVault(user.api_key)">Test API Key</button>
            </div>
        </Transition>

        <!--
            *
            * BENCHMARKS
            *
        -->
        <header 
            id="nav"
            @click="benchmarksToggle = !benchmarksToggle"
        >
            <h5>Benchmarks</h5>
            <svg 
                class="expand"
                :class="{rotate180: benchmarksToggle}" 
                width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M8.81372 0.397634C8.6944 0.280464 8.5326 0.214642 8.36389 0.214642C8.19519 0.214642 8.03339 0.280464 7.91407 0.397634L4.76468 3.49138L1.61529 0.397634C1.49529 0.283785 1.33457 0.220788 1.16775 0.222212C1.00093 0.223636 0.841356 0.289367 0.723392 0.405247C0.605428 0.521127 0.538516 0.677885 0.537066 0.841758C0.535617 1.00563 0.599746 1.16351 0.715642 1.28138L4.31486 4.81701C4.43417 4.93418 4.59597 5 4.76468 5C4.93339 5 5.09519 4.93418 5.2145 4.81701L8.81372 1.28138C8.93299 1.16418 9 1.00524 9 0.839509C9 0.673781 8.93299 0.514838 8.81372 0.397634Z" fill="#FFD12C"/>
            </svg>
        </header>

        <Transition name="fade-right">
            <section v-if="benchmarksToggle">
                <router-link class="page-link" to="/benchmarks/maps">
                    <img src="@/imgs/icons/Commander_Icon.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                    <h6>Maps</h6>
                </router-link>

                <!-- <router-link class="page-link" to="/benchmarks/fishing">
                    <img src="../../../imgs/icons/Fishing.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                    <h6>Fishing</h6>
                </router-link>

                <router-link class="page-link" to="/benchmarks/fishing">
                    <img src="../../../imgs/icons/Gathering_UI_Icon.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                    <h6>Gathering</h6>
                </router-link>

                <router-link class="page-link" to="/benchmarks/fishing">
                    <img src="../../../imgs/icons/Red_Boss.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                    <h6>Metas</h6>
                </router-link>

                <router-link class="page-link" to="/benchmarks/fishing">
                    <img src="../../../imgs/icons/Guild_Armorer.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                    <h6>Alt Parking</h6>
                </router-link> -->
            </section>
        </Transition>

        <!--
            *
            * CURRENCIES
            *
        -->
        <header @click="curriencesToggle = !curriencesToggle" id="nav">
            <h5>Curriences</h5>
            <svg 
                class="expand"
                :class="{rotate180: curriencesToggle}" 
                width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M8.81372 0.397634C8.6944 0.280464 8.5326 0.214642 8.36389 0.214642C8.19519 0.214642 8.03339 0.280464 7.91407 0.397634L4.76468 3.49138L1.61529 0.397634C1.49529 0.283785 1.33457 0.220788 1.16775 0.222212C1.00093 0.223636 0.841356 0.289367 0.723392 0.405247C0.605428 0.521127 0.538516 0.677885 0.537066 0.841758C0.535617 1.00563 0.599746 1.16351 0.715642 1.28138L4.31486 4.81701C4.43417 4.93418 4.59597 5 4.76468 5C4.93339 5 5.09519 4.93418 5.2145 4.81701L8.81372 1.28138C8.93299 1.16418 9 1.00524 9 0.839509C9 0.673781 8.93299 0.514838 8.81372 0.397634Z" fill="#FFD12C"/>
            </svg>
        </header>

        <Transition name="fade-right">
            <section v-if="curriencesToggle">
                <!--
                    *
                    * CORE CURRIENCES
                    *
                -->
                <div class="distinquish-section">
                    <div class="label" id="core">
                        <h6>Core</h6>
                    </div>

                    <div class="routes">
                        <router-link class="page-link" to="/currencies/laurel">
                            <img src="@/imgs/icons/Laurel.png" alt="Laurel" title="Laurel">
                            <h6>Laurel</h6>
                        </router-link>
                        
                        <router-link class="page-link" to="/currencies/spirit-shards">
                            <img src="@/imgs/icons/Spirit_Shard.png" alt="Spirit Shard" title="Spirit Shard">
                            <h6>Spirit Shards</h6>
                        </router-link>
                    </div>   
                </div>
                <div class="distinquish-section">
                    <div class="label" id="pof">
                        <h6>PoF</h6>
                    </div>

                    <div class="routes">
                        <router-link class="page-link" to="/currencies/trade-contract">
                            <img src="@/imgs/icons/Trade_Contract.png" alt="Trade Contract" title="Trade Contract">
                            <h6>Trade Contract</h6>
                        </router-link>
                    </div>   
                </div>
                <!--
                    *
                    * LS3 CURRIENCES
                    *
                -->
                <div class="distinquish-section">
                    <div class="label" id="ls3">
                        <h6>LS3</h6>
                    </div>

                    <div class="routes">
                        <router-link class="page-link" to="/currencies/unbound-magic">
                            <img src="@/imgs/icons/Unbound_Magic.png" alt="Unbound Magic" title="Unbound Magic">
                            <h6>Unbound Magic</h6>
                        </router-link>
                    </div>   
                </div>
                <!--
                    *
                    * LS4 CURRIENCES
                    *
                -->
                <div class="distinquish-section">
                    <div class="label" id="ls4">
                        <h6>LS4</h6>
                    </div>

                    <div class="routes">
                        <router-link class="page-link" to="/currencies/volatile-magic">
                            <img src="@/imgs/icons/Volatile_Magic.png" alt="Volatile Magic" title="Volatile Magic">
                            <h6>Volatile Magic</h6>
                        </router-link>
                    </div>   
                </div>
            </section>
        </Transition>

        <!--
            *
            * TOOLS
            *
        -->
        <header @click="toolsToggle = !toolsToggle">
            <h5>Tools</h5>
            <svg 
                class="expand"
                :class="{rotate180: toolsToggle}" 
                width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M8.81372 0.397634C8.6944 0.280464 8.5326 0.214642 8.36389 0.214642C8.19519 0.214642 8.03339 0.280464 7.91407 0.397634L4.76468 3.49138L1.61529 0.397634C1.49529 0.283785 1.33457 0.220788 1.16775 0.222212C1.00093 0.223636 0.841356 0.289367 0.723392 0.405247C0.605428 0.521127 0.538516 0.677885 0.537066 0.841758C0.535617 1.00563 0.599746 1.16351 0.715642 1.28138L4.31486 4.81701C4.43417 4.93418 4.59597 5 4.76468 5C4.93339 5 5.09519 4.93418 5.2145 4.81701L8.81372 1.28138C8.93299 1.16418 9 1.00524 9 0.839509C9 0.673781 8.93299 0.514838 8.81372 0.397634Z" fill="#FFD12C"/>
            </svg>
        </header>

        <Transition name="fade-right">
            <section v-if="toolsToggle">
                <!--
                    *
                    * HOT TIMERS
                    *
                -->
                <div class="distinquish-section">
                    <div class="label" id="hot">
                        <h6>Merp</h6>
                    </div>

                    <div class="routes">
                        

                        <router-link class="page-link" to="/tools/recipe-value">
                            <img src="@/imgs/icons/Ley_Line_Crystal.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Recipe Value</h6>
                        </router-link>

                        <router-link class="page-link" to="/tools/research-notes">
                            <img src="@/imgs/icons/Research_Note.png" alt="Research Notes" title="Tools - Research Notes">
                            <h6>Research Notes</h6>
                        </router-link>

                        <router-link class="page-link" to="/tools/salvageables">
                            <img src="@/imgs/icons/Piece_of_Unidentified_Gear.png" alt="Salvageables" title="Tools - Salvageables">
                            <h6>Salvageables</h6>
                        </router-link>

                        
                    </div>   
                </div>
            </section>
        </Transition>

        <!--
            *
            * TIMERS
            *
        -->
        <header @click="timersToggle = !timersToggle">
            <h5>Timers</h5>
            <svg 
                class="expand"
                :class="{rotate180: timersToggle}" 
                width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M8.81372 0.397634C8.6944 0.280464 8.5326 0.214642 8.36389 0.214642C8.19519 0.214642 8.03339 0.280464 7.91407 0.397634L4.76468 3.49138L1.61529 0.397634C1.49529 0.283785 1.33457 0.220788 1.16775 0.222212C1.00093 0.223636 0.841356 0.289367 0.723392 0.405247C0.605428 0.521127 0.538516 0.677885 0.537066 0.841758C0.535617 1.00563 0.599746 1.16351 0.715642 1.28138L4.31486 4.81701C4.43417 4.93418 4.59597 5 4.76468 5C4.93339 5 5.09519 4.93418 5.2145 4.81701L8.81372 1.28138C8.93299 1.16418 9 1.00524 9 0.839509C9 0.673781 8.93299 0.514838 8.81372 0.397634Z" fill="#FFD12C"/>
            </svg>
        </header>

        <Transition name="fade-right">
            <section v-if="timersToggle">
                <!--
                    *
                    * HOT TIMERS
                    *
                -->
                <div class="distinquish-section">
                    <div class="label" id="hot">
                        <h6>HoT</h6>
                    </div>

                    <div class="routes">
                        <!-- <router-link class="page-link" to="/benchmarks/maps">
                            <img src="../../../imgs/icons/Airship_Part.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Verdant Brink</h6>
                        </router-link> -->

                        <router-link class="page-link" to="/timers/auric-basin">
                            <img src="@/imgs/icons/Lump_of_Aurillium.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Auric Basin</h6>
                        </router-link>

                        <router-link class="page-link" to="/timers/tangled-depths">
                            <img src="@/imgs/icons/Ley_Line_Crystal.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Tangled Depths</h6>
                        </router-link>
                    </div>   
                </div>
                <!--
                    *
                    * LS3 TIMERS
                    *
                -->
                <div class="distinquish-section">
                    <div class="label" id="ls3">
                        <h6>LS3</h6>
                    </div>

                    <div class="routes">
                        <router-link class="page-link" to="/timers/ember-bay">
                            <img src="@/imgs/icons/Petrified_Wood.png" alt="Petrified Wood" title="Timers - Ember Bay">
                            <h6>Ember Bay</h6>
                        </router-link>
                    </div>   
                </div>
                <!--
                    *
                    * POF TIMERS
                    *
                -->
                <!-- <div class="distinquish-section">
                    <div class="label" id="pof">
                        <h6>POF</h6>
                    </div>

                    <div class="routes">
                        <router-link class="page-link" to="/benchmarks/maps">
                            <img src="../../../imgs/icons/Springer.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Desert Highlands</h6>
                        </router-link>

                        <router-link class="page-link" to="/benchmarks/maps">
                            <img src="../../../imgs/icons/Raptor.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Crystal Oasis</h6>
                        </router-link>

                        <router-link class="page-link" to="/benchmarks/maps">
                            <img src="../../../imgs/icons/Skimmer.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Elon Riverlands</h6>
                        </router-link>

                        <router-link class="page-link" to="/benchmarks/maps">
                            <img src="../../../imgs/icons/Jackal.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Desolation</h6>
                        </router-link>

                        <router-link class="page-link" to="/benchmarks/maps">
                            <img src="../../../imgs/icons/Griffon.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Domain of Vabbi</h6>
                        </router-link>
                    </div>   
                </div> -->
                <!--
                    *
                    * LS4 TIMERS
                    *
                -->
                <div class="distinquish-section">
                    <div class="label" id="ls4">
                        <h6>LS4</h6>
                    </div>

                    <div class="routes">
                        <router-link class="page-link" to="/timers/domain-of-istan">
                            <img src="@/imgs/icons/Kralkatite_Ore.png" alt="Kralkatite Ore" title="timers/domain-of-istan">
                            <h6>Domain of Istan</h6>
                        </router-link>

                        <router-link class="page-link" to="/timers/sandswept-isles">
                            <img src="@/imgs/icons/Difluorite_Crystal.png" alt="Difluorite Crystal" title="timers/sandswept-isles">
                            <h6>Sandswept Isles</h6>
                        </router-link>

                        <router-link class="page-link" to="/timers/domain-of-kourna">
                            <img src="@/imgs/icons/Inscribed_Shard.png" alt="Inscribed Shard" title="timers/domain-of-kourna">
                            <h6>Domain of Kourna</h6>
                        </router-link>
                        
                        <router-link class="page-link" to="/timers/dragonfall">
                            <img src="@/imgs/icons/Mistborn_Mote.png" alt="Mistborn Mote" title="timers/dragonfall">
                            <h6>Dragonfall</h6>
                        </router-link>
                    </div>   
                </div>
                <!--
                    *
                    * SOTO TIMERS
                    *
                -->
                <div class="distinquish-section">
                    <div class="label" id="soto">
                        <h6>SOTO</h6>
                    </div>

                    <div class="routes">
                        <router-link class="page-link" to="/timers/skywatch-archipelago">
                            <img src="@/imgs/icons/Static_Charge.png" alt="Static Charge" title="timers/skywatch-archipelago">
                            <h6>Skywatch Archipelago</h6>
                        </router-link>
                    </div>   
                </div>
            </section>
        </Transition>
    </nav>
</template>

<script setup>
import { ref, watch, provide, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import { scrollTo } from '@/js/vue/composables/NavFunctions.js'
import { nodeTrackerModalToggle } from '@/js/vue/composables/Global.js';
import { convertTaxToPercent } from '@/js/vue/composables/BasicFunctions.js'
import { pageRefresh } from '@/js/vue/composables/BasicFunctions.js'
import axios from 'axios';

// Initialize form fields
const name = ref(''), 
    email = ref(''),
    password = ref(''),
    remember = ref(null);
// Auth user
const user = ref(null);

const wv = ref(null); 

const getWizardsVault = async (key) => {
    try {
        console.log(key); 
        const response = await fetch(`https://api.guildwars2.com/v2/account/wizardsvault/daily?access_token=${key}`);

        wv.value = await response.json(); 
        console.log(wv.value);
        
    } catch (error){
        console.log("Error retreiving Wizard's Vault info: ", error); 
    }
}

// *
// * LOGIN
// * Assuming a completed form with username, email, password => login into a new session 
// * Refresh page if successful
const login = async () => {
    try {
        // Get unique cookie? 
        await axios.get('../sanctum/csrf-cookie');
        // Send POST to /login via web.php route: 
        // LoginController.php, authenticate(); 
        // Use the v-model form values to verify registered user
        const response = await axios.post('../login', {
            name: name.value,
            email: email.value,
            password: password.value,
            remember: remember.value,
        }, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        // If sucessful, page refresh
        if (response){
            console.log("Login successful!");
            handlePageRefresh();
        } 
    } catch (error) {
        console.log('Login error: ', error);
    }
}

const logout = async () => {
    try {
        const response = await axios.post('../logout');

        if (response){
            console.log('Logout successful!');
            handlePageRefresh();
        }
    } catch (error){
        console.log('Logout failed: ', error);
    }
}

const register = async () => {
  try {
        const response = await fetch('../register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                name: name.value,
                email: email.value,
                password: password.value,
            }),
        });

        if (!response.ok) {
            throw new Error('Registration failed');
        }

    // Redirect or handle success as needed
    } catch (error) {
        console.error('Registration error:', error);
        // Handle error (e.g., show error message)
    }
};
// *
// * GET LOGGED USER AFTER MOUNTED
// * 
const getAuthUser = async () => {
    try {
        const response = await fetch('../api/user');
        if (!response.ok){
            throw new Error('Failed to fetch user data');
        }
        user.value = await response.json(); 
    } catch (error){
        console.log(error); 
    }
}

const enterAPIKey = async () => {
    try{
        const response = await axios.post('../api/user/enterAPIKey', {
            apiKey: apiKey.value,
        })

        // If sucessful, page refresh
        if (response){
            console.log("API key successful!");
            //handlePageRefresh();
        } 
    } catch (error){
        console.log("API key failure: ", error); 
    }
    
}

onMounted( async () => {
    getAuthUser(); 
})

// For first time visitors
// If there is no exisiting local stoarge property (like sellOrderSetting), then make one by default
// Otherwise, don't do anything
const setDefaultLocalStorage = () => {
    // * SETTINGS
    // * 
    // *
    if (!localStorage.settings){
        localStorage.setItem('settings', false);
    }
    if (!localStorage.buyOrderSetting){
        localStorage.setItem('buyOrderSetting', 'buy_price');
    }
    if (!localStorage.sellOrderSetting){
        localStorage.setItem('sellOrderSetting', 'sell_price'); 
    }
    if (!localStorage.taxSetting){
        localStorage.setItem('taxSetting', 0.85);
    }
    // * 
    // * FILTERS
    // *
    if (!localStorage.filtersToggle){
        localStorage.setItem('filters', false);
    }
    // * 
    // * FILTER RESEARCH NOTES
    // *
    if (!localStorage.filterResearchNotes){
        localStorage.setItem('filterResearchNotes', JSON.stringify([
            "TP", 
            "Crafting",
            "Armorsmith",
            "Artifier",
            "Chef",
            "Huntsman",
            "Jeweler",
            "Leatherworker",
            "Scribe",
            "Tailor",
            "Weaponsmith",
            "Consumable",
            "Weapon",
            "Armor",
            "Back",
            "Trinket",
            "UpgradeComponent",
        ])); 
    }
    // * BOOKMARKS
    // * 
    // * Set different bookmarks for different pages if applicable
    if (!localStorage.bookmarks){
        localStorage.setItem('bookmarks', true);
    }
    
    if (!localStorage.spiritShardsFineT2Table){
        localStorage.setItem('spiritShardsFineT2Table', true);
    }
    if (!localStorage.spiritShardsFineT3Table){
        localStorage.setItem('spiritShardsFineT3Table', true);
    }
    if (!localStorage.spiritShardsFineT4Table){
        localStorage.setItem('spiritShardsFineT4Table', true);
    }
    if (!localStorage.spiritShardsFineT5Table){
        localStorage.setItem('spiritShardsFineT5Table', true);
    }
    if (!localStorage.spiritShardsFineT6Table){
        localStorage.setItem('spiritShardsFineT6Table', true);
    }
    if (!localStorage.spiritShardsRareT2Table){
        localStorage.setItem('spiritShardsRareT2Table', true);
    }
    if (!localStorage.spiritShardsRareT3Table){
        localStorage.setItem('spiritShardsRareT3Table', true);
    }
    if (!localStorage.spiritShardsRareT4Table){
        localStorage.setItem('spiritShardsRareT4Table', true);
    }
    if (!localStorage.spiritShardsRareT5Table){
        localStorage.setItem('spiritShardsRareT5Table', true);
    }
}
setDefaultLocalStorage(); 

const benchmarksToggle = ref(true),
    curriencesToggle = ref(true),
    toolsToggle = ref(true),
    timersToggle = ref(true);

const settingsToggle = ref(JSON.parse(localStorage.settings)),
    filtersToggle = ref(JSON.parse(localStorage.filters)),
    bookmarksToggle = ref(JSON.parse(localStorage.bookmarks)),
    loginToggle = ref(false),
    apiKeyToggle = ref(false);

const buyOrderSetting = ref(localStorage.buyOrderSetting),
    sellOrderSetting = ref(localStorage.sellOrderSetting),
    taxSetting = ref(parseFloat(localStorage.taxSetting)),
    apiKey = ref(null);

const route = useRoute(),
    router = useRouter();

const handlePageRefresh = () => {
    pageRefresh(router, route);
}

const changeOrder = (order) => {
    switch (order){
        case 'sell order': 
            if (sellOrderSetting.value == 'sell_price'){
                sellOrderSetting.value = 'buy_price';
            } else {
                sellOrderSetting.value = 'sell_price';
            }
            break;
        case 'buy order':
            if (buyOrderSetting.value == 'buy_price'){
                buyOrderSetting.value = 'sell_price';
            } else {
                buyOrderSetting.value = 'buy_price';
            }
    }
    localStorage.setItem('sellOrderSetting', sellOrderSetting.value);
    localStorage.setItem('buyOrderSetting', buyOrderSetting.value);
}
// Change the localStorage value of whether or not to have the bookmarks tab always open or not
const changeBookmarksToggle = () => {
    bookmarksToggle.value = !bookmarksToggle.value; 
    localStorage.bookmarks = bookmarksToggle.value;
}
const changeSettingsToggle = () => {
    settingsToggle.value = !settingsToggle.value;
    localStorage.settings = settingsToggle.value;
}
const changeFiltersToggle = () => {
    filtersToggle.value = !filtersToggle.value;
    localStorage.filters = filtersToggle.value;
}


watch(taxSetting, (newTaxSetting) => {
    if (newTaxSetting == ''){
        newTaxSetting = 0.85;
    }
    localStorage.taxSetting = newTaxSetting;
})

</script>

<style scoped>
.form-container{
    padding: var(--padding-settings);
}
.form-container input{
    width: 100%;
    margin-bottom: 10px;
}

form .form-button-container{
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    padding-top: 10px;
}
form .remember-container{
    display: flex;
    align-items: center;
}
form .remember-container label{
    white-space: nowrap;
}
form .remember-container input{
    margin-bottom: unset;
}


.shortcut-container{
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: var(--padding-settings);
    gap: 10px;
    border-bottom: var(--border-bottom);
}

.settings-button-container{
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.settings-button{
    display: flex;
}
.settings-button button{
    border: var(--border-general);
}
.settings-button-container input {
    width: 50%;
}
.settings-tax-input{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 5px;
}
.settings-tax-model{
    display: flex;
    align-items: center;
    gap: 5px;
}
.settings-tax-model svg{
    transition: var(--transition-all-03s-ease);
}
</style>
