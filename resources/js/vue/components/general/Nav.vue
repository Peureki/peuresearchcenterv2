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
                        @click="settingsToggle = !settingsToggle"
                        width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg"
                        id="cog"
                    >
                        <path d="M10.5 14.146C9.53308 14.146 8.60575 13.7619 7.92202 13.0782C7.2383 12.3944 6.85418 11.4671 6.85418 10.5002C6.85418 9.53323 7.2383 8.6059 7.92202 7.92217C8.60575 7.23845 9.53308 6.85433 10.5 6.85433C11.467 6.85433 12.3943 7.23845 13.078 7.92217C13.7617 8.6059 14.1458 9.53323 14.1458 10.5002C14.1458 11.4671 13.7617 12.3944 13.078 13.0782C12.3943 13.7619 11.467 14.146 10.5 14.146ZM18.2396 11.5106C18.2813 11.1772 18.3125 10.8439 18.3125 10.5002C18.3125 10.1564 18.2813 9.81267 18.2396 9.4585L20.4375 7.76058C20.6354 7.60433 20.6875 7.32308 20.5625 7.09391L18.4792 3.48975C18.3542 3.26058 18.0729 3.16683 17.8438 3.26058L15.25 4.30225C14.7083 3.896 14.1458 3.54183 13.4896 3.28142L13.1042 0.520998C13.083 0.398308 13.0191 0.287068 12.9238 0.206989C12.8285 0.126911 12.7079 0.083163 12.5833 0.083498H8.41668C8.15627 0.083498 7.93752 0.270998 7.89585 0.520998L7.51043 3.28142C6.85418 3.54183 6.29168 3.896 5.75002 4.30225L3.15627 3.26058C2.9271 3.16683 2.64585 3.26058 2.52085 3.48975L0.437516 7.09391C0.302099 7.32308 0.364599 7.60433 0.562516 7.76058L2.76043 9.4585C2.71877 9.81267 2.68752 10.1564 2.68752 10.5002C2.68752 10.8439 2.71877 11.1772 2.76043 11.5106L0.562516 13.2397C0.364599 13.396 0.302099 13.6772 0.437516 13.9064L2.52085 17.5106C2.64585 17.7397 2.9271 17.8231 3.15627 17.7397L5.75002 16.6877C6.29168 17.1043 6.85418 17.4585 7.51043 17.7189L7.89585 20.4793C7.93752 20.7293 8.15627 20.9168 8.41668 20.9168H12.5833C12.8438 20.9168 13.0625 20.7293 13.1042 20.4793L13.4896 17.7189C14.1458 17.4481 14.7083 17.1043 15.25 16.6877L17.8438 17.7397C18.0729 17.8231 18.3542 17.7397 18.4792 17.5106L20.5625 13.9064C20.6875 13.6772 20.6354 13.396 20.4375 13.2397L18.2396 11.5106Z" fill="#FFD12C"/>
                        <title>Settings</title>
                    </svg>
                    <!-- SUN  -->
                    <!-- <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.7188 3.90625V1.5625C11.7188 1.3553 11.8011 1.15659 11.9476 1.01007C12.0941 0.86356 12.2928 0.78125 12.5 0.78125C12.7072 0.78125 12.9059 0.86356 13.0524 1.01007C13.1989 1.15659 13.2812 1.3553 13.2812 1.5625V3.90625C13.2812 4.11345 13.1989 4.31216 13.0524 4.45868C12.9059 4.60519 12.7072 4.6875 12.5 4.6875C12.2928 4.6875 12.0941 4.60519 11.9476 4.45868C11.8011 4.31216 11.7188 4.11345 11.7188 3.90625ZM12.5 6.25C11.2639 6.25 10.0555 6.61656 9.02769 7.30331C7.99988 7.99007 7.1988 8.96619 6.72575 10.1082C6.25271 11.2503 6.12893 12.5069 6.37009 13.7193C6.61125 14.9317 7.2065 16.0453 8.08058 16.9194C8.95466 17.7935 10.0683 18.3888 11.2807 18.6299C12.4931 18.8711 13.7497 18.7473 14.8918 18.2742C16.0338 17.8012 17.0099 17.0001 17.6967 15.9723C18.3834 14.9445 18.75 13.7361 18.75 12.5C18.7482 10.843 18.0891 9.25429 16.9174 8.08258C15.7457 6.91087 14.157 6.25181 12.5 6.25ZM5.69727 6.80273C5.84386 6.94933 6.04268 7.03168 6.25 7.03168C6.45732 7.03168 6.65614 6.94933 6.80273 6.80273C6.94933 6.65614 7.03168 6.45732 7.03168 6.25C7.03168 6.04268 6.94933 5.84386 6.80273 5.69727L5.24023 4.13477C5.09364 3.98817 4.89482 3.90582 4.6875 3.90582C4.48018 3.90582 4.28136 3.98817 4.13477 4.13477C3.98817 4.28136 3.90582 4.48018 3.90582 4.6875C3.90582 4.89482 3.98817 5.09364 4.13477 5.24023L5.69727 6.80273ZM5.69727 18.1973L4.13477 19.7598C3.98817 19.9064 3.90582 20.1052 3.90582 20.3125C3.90582 20.5198 3.98817 20.7186 4.13477 20.8652C4.28136 21.0118 4.48018 21.0942 4.6875 21.0942C4.89482 21.0942 5.09364 21.0118 5.24023 20.8652L6.80273 19.3027C6.87532 19.2301 6.9329 19.144 6.97218 19.0491C7.01147 18.9543 7.03168 18.8527 7.03168 18.75C7.03168 18.6473 7.01147 18.5457 6.97218 18.4509C6.9329 18.356 6.87532 18.2699 6.80273 18.1973C6.73015 18.1247 6.64398 18.0671 6.54914 18.0278C6.4543 17.9885 6.35265 17.9683 6.25 17.9683C6.14735 17.9683 6.0457 17.9885 5.95086 18.0278C5.85602 18.0671 5.76985 18.1247 5.69727 18.1973ZM18.75 7.03125C18.8526 7.03133 18.9543 7.01119 19.0491 6.97198C19.1439 6.93277 19.2301 6.87526 19.3027 6.80273L20.8652 5.24023C21.0118 5.09364 21.0942 4.89482 21.0942 4.6875C21.0942 4.48018 21.0118 4.28136 20.8652 4.13477C20.7186 3.98817 20.5198 3.90582 20.3125 3.90582C20.1052 3.90582 19.9064 3.98817 19.7598 4.13477L18.1973 5.69727C18.0879 5.80653 18.0134 5.94579 17.9832 6.09742C17.953 6.24905 17.9685 6.40622 18.0276 6.54906C18.0868 6.69189 18.187 6.81394 18.3156 6.89978C18.4442 6.98562 18.5954 7.03137 18.75 7.03125ZM19.3027 18.1973C19.1561 18.0507 18.9573 17.9683 18.75 17.9683C18.5427 17.9683 18.3439 18.0507 18.1973 18.1973C18.0507 18.3439 17.9683 18.5427 17.9683 18.75C17.9683 18.9573 18.0507 19.1561 18.1973 19.3027L19.7598 20.8652C19.8324 20.9378 19.9185 20.9954 20.0134 21.0347C20.1082 21.074 20.2098 21.0942 20.3125 21.0942C20.4152 21.0942 20.5168 21.074 20.6116 21.0347C20.7065 20.9954 20.7926 20.9378 20.8652 20.8652C20.9378 20.7926 20.9954 20.7065 21.0347 20.6116C21.074 20.5168 21.0942 20.4152 21.0942 20.3125C21.0942 20.2098 21.074 20.1082 21.0347 20.0134C20.9954 19.9185 20.9378 19.8324 20.8652 19.7598L19.3027 18.1973ZM4.6875 12.5C4.6875 12.2928 4.60519 12.0941 4.45868 11.9476C4.31216 11.8011 4.11345 11.7188 3.90625 11.7188H1.5625C1.3553 11.7188 1.15659 11.8011 1.01007 11.9476C0.86356 12.0941 0.78125 12.2928 0.78125 12.5C0.78125 12.7072 0.86356 12.9059 1.01007 13.0524C1.15659 13.1989 1.3553 13.2812 1.5625 13.2812H3.90625C4.11345 13.2812 4.31216 13.1989 4.45868 13.0524C4.60519 12.9059 4.6875 12.7072 4.6875 12.5ZM12.5 20.3125C12.2928 20.3125 12.0941 20.3948 11.9476 20.5413C11.8011 20.6878 11.7188 20.8865 11.7188 21.0938V23.4375C11.7188 23.6447 11.8011 23.8434 11.9476 23.9899C12.0941 24.1364 12.2928 24.2188 12.5 24.2188C12.7072 24.2188 12.9059 24.1364 13.0524 23.9899C13.1989 23.8434 13.2812 23.6447 13.2812 23.4375V21.0938C13.2812 20.8865 13.1989 20.6878 13.0524 20.5413C12.9059 20.3948 12.7072 20.3125 12.5 20.3125ZM23.4375 11.7188H21.0938C20.8865 11.7188 20.6878 11.8011 20.5413 11.9476C20.3948 12.0941 20.3125 12.2928 20.3125 12.5C20.3125 12.7072 20.3948 12.9059 20.5413 13.0524C20.6878 13.1989 20.8865 13.2812 21.0938 13.2812H23.4375C23.6447 13.2812 23.8434 13.1989 23.9899 13.0524C24.1364 12.9059 24.2188 12.7072 24.2188 12.5C24.2188 12.2928 24.1364 12.0941 23.9899 11.9476C23.8434 11.8011 23.6447 11.7188 23.4375 11.7188Z" fill="#FFD12C"/>
                        <title>Toggle dark/light mode</title>
                    </svg> -->

                    <!-- BOOKMARKS -->
                    <svg 
                        @click="changeBookmarksToggle(bookmarksToggle)"
                        width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 18V0H14V18L7 15L0 18Z" fill="#FFD12C"/>
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
                    <!-- DISCORD  -->
                    <svg width="25" height="17" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.1532 1.4128C19.5698 0.754226 17.8554 0.276227 16.0697 4.88603e-05C16.054 -0.000397914 16.0385 0.00222374 16.0241 0.00772953C16.0097 0.0132353 15.9968 0.0214915 15.9863 0.0319157C15.7721 0.382449 15.522 0.839204 15.3554 1.18974C13.4613 0.934804 11.535 0.934804 9.64094 1.18974C9.47427 0.828582 9.22426 0.382449 8.99806 0.0319157C8.98616 0.0106713 8.95044 4.88603e-05 8.91473 4.88603e-05C7.12896 0.276227 5.42653 0.754226 3.83125 1.4128C3.81935 1.4128 3.80744 1.42343 3.79554 1.43405C0.557354 5.75729 -0.335528 9.96369 0.10496 14.1276C0.10496 14.1488 0.116865 14.1701 0.140675 14.1807C2.28359 15.5828 4.34317 16.4326 6.37894 16.9956C6.41466 17.0062 6.45037 16.9956 6.46228 16.9744C6.93848 16.3901 7.36706 15.774 7.73612 15.1261C7.75993 15.0836 7.73612 15.0411 7.6885 15.0305C7.00991 14.7968 6.36704 14.5206 5.73607 14.202C5.68845 14.1807 5.68845 14.117 5.72416 14.0851C5.85512 14.0001 5.98607 13.9045 6.11703 13.8196C6.14084 13.7983 6.17656 13.7983 6.20037 13.8089C10.2957 15.4766 14.7125 15.4766 18.7602 13.8089C18.784 13.7983 18.8198 13.7983 18.8436 13.8196C18.9745 13.9152 19.1055 14.0001 19.2364 14.0957C19.2841 14.1276 19.2841 14.1913 19.2245 14.2126C18.6055 14.5419 17.9507 14.8074 17.2721 15.0411C17.2245 15.0517 17.2126 15.1048 17.2245 15.1367C17.6054 15.7847 18.034 16.4008 18.4983 16.985C18.534 16.9956 18.5698 17.0062 18.6055 16.9956C20.6531 16.4326 22.7127 15.5828 24.8556 14.1807C24.8794 14.1701 24.8914 14.1488 24.8914 14.1276C25.4152 9.31573 24.0223 5.1412 21.2008 1.43405C21.1889 1.42343 21.177 1.4128 21.1532 1.4128ZM8.35519 11.5889C7.12896 11.5889 6.10512 10.5798 6.10512 9.33698C6.10512 8.09418 7.10515 7.08507 8.35519 7.08507C9.61713 7.08507 10.6172 8.1048 10.6052 9.33698C10.6052 10.5798 9.60522 11.5889 8.35519 11.5889ZM16.653 11.5889C15.4268 11.5889 14.403 10.5798 14.403 9.33698C14.403 8.09418 15.403 7.08507 16.653 7.08507C17.915 7.08507 18.915 8.1048 18.9031 9.33698C18.9031 10.5798 17.915 11.5889 16.653 11.5889Z" fill="#FFD12C"/>
                        <title>Discord</title>
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
            * SLOT - TIMERS
            * 
            * This changes depending on what timer page the website is currently on
        -->
        <slot name="timer"></slot>
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
            * SETTINGS / OPTIONS
            * 
        -->
        <Transition name="fade-right">
            <section v-if="settingsToggle">
                <article class="settings-container">
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
                                :style="{
                                    opacity: buyOrderSetting == 'buy_price' ? 1 : 0.2,
                                    backgroundColor: buyOrderSetting == 'buy_price' ? 'var(--color-link)' : 'transparent',
                                    color: buyOrderSetting == 'buy_price' ? 'var(--color-black)' : 'var(--color-text)',
                                }"
                            >
                                Buy Price
                            </button>
                            <button
                                @click="changeOrder('buy order')"
                                :style="{
                                    opacity: buyOrderSetting == 'sell_price' ? 1 : 0.2,
                                    backgroundColor: buyOrderSetting == 'sell_price' ? 'var(--color-link)' : 'transparent',
                                    color: buyOrderSetting == 'sell_price' ? 'var(--color-black)' : 'var(--color-text)',
                                }"
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
                                :style="{
                                    opacity: sellOrderSetting == 'buy_price' ? 1 : 0.2,
                                    backgroundColor: sellOrderSetting == 'buy_price' ? 'var(--color-link)' : 'transparent',
                                    color: sellOrderSetting == 'buy_price' ? 'var(--color-black)' : 'var(--color-text)',
                                }"
                            >
                                Buy Price
                            </button>
                            <button
                                @click="changeOrder('sell order')"
                                :style="{
                                    opacity: sellOrderSetting == 'sell_price' ? 1 : 0.2,
                                    backgroundColor: sellOrderSetting == 'sell_price' ? 'var(--color-link)' : 'transparent',
                                    color: sellOrderSetting == 'sell_price' ? 'var(--color-black)' : 'var(--color-text)',
                                }"
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
                            <input type="text" id="tax" name="tax" v-model="taxSetting">
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
                            @click="refreshPage"    
                            class="settings-submit"
                        >
                            Submit
                        </button>
                    </div>
                    
                </article>
            
            </section>
        </Transition>

        <!--
            *
            * BENCHMARKS
            *
        -->
        <!-- <header 
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
                    <img src="../../../imgs/icons/Commander_Icon.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                    <h6>Maps</h6>
                </router-link>

                <router-link class="page-link" to="/benchmarks/fishing">
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
                </router-link>
            </section>
        </Transition> -->

        <!--
            *
            * CURRENCIES
            *
        -->
        <header @click="curriencesToggle = !curriencesToggle">
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
                        <router-link class="page-link" to="/currencies/spirit-shards">
                            <img src="@/imgs/icons/Spirit_Shard.png" alt="Spirit Shard" title="Spirit Shard">
                            <h6>Spirit Shards</h6>
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
                <!-- <div class="distinquish-section">
                    <div class="label" id="ls3">
                        <h6>LS3</h6>
                    </div>

                    <div class="routes">
                        <router-link class="page-link" to="/benchmarks/maps">
                            <img src="../../../imgs/icons/Blood_Ruby.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Bloodstone Fen</h6>
                        </router-link>

                        <router-link class="page-link" to="/benchmarks/maps">
                            <img src="../../../imgs/icons/Petrified_Wood.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Ember Bay</h6>
                        </router-link>

                        <router-link class="page-link" to="/benchmarks/maps">
                            <img src="../../../imgs/icons/Fresh_Winterberry.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Bitterfrost Frontier</h6>
                        </router-link>

                        <router-link class="page-link" to="/benchmarks/maps">
                            <img src="../../../imgs/icons/Fire_Orchid_Blossom.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Draconis Mons</h6>
                        </router-link>

                        <router-link class="page-link" to="/benchmarks/maps">
                            <img src="../../../imgs/icons/Orrian_Pearl.png" alt="Blue commander tag redirecting to the benchmarks maps page" title="Benchmarks - Maps">
                            <h6>Siren's Landing</h6>
                        </router-link>
                    </div>   
                </div> -->
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
import { ref, watch, provide } from 'vue'

import { scrollTo } from '@/js/vue/composables/NavFunctions.js'
import { nodeTrackerModalToggle } from '@/js/vue/composables/Global.js';
import { refreshPage, convertTaxToPercent } from '@/js/vue/composables/BasicFunctions.js'

// For first time visitors
// If there is no exisiting local stoarge property (like sellOrderSetting), then make one by default
// Otherwise, don't do anything
const setDefaultLocalStorage = () => {
    // * SETTINGS
    // * 
    // *
    if (!localStorage.buyOrderSetting){
        localStorage.setItem('buyOrderSetting', 'buy_price');
    }
    if (!localStorage.sellOrderSetting){
        localStorage.setItem('sellOrderSetting', 'sell_price'); 
    }
    if (!localStorage.taxSetting){
        localStorage.setItem('taxSetting', 0.85);
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
    timersToggle = ref(true);

const settingsToggle = ref(false),
    bookmarksToggle = ref(JSON.parse(localStorage.bookmarks));
    

const buyOrderSetting = ref(localStorage.buyOrderSetting),
    sellOrderSetting = ref(localStorage.sellOrderSetting),
    taxSetting = ref(parseFloat(localStorage.taxSetting));

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

const changeBookmarksToggle = (bookmarksToggle) => {
    bookmarksToggle.value = !bookmarksToggle.value;
    // localStorage.setItem('bookmarks', bookmarks.value);
}

watch(taxSetting, (newTaxSetting) => {
    if (newTaxSetting == ''){
        newTaxSetting = 0.85;
    }
    localStorage.taxSetting = newTaxSetting;
})

</script>

<style scoped>
.settings-container{
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
    width: 50%;
    background-color: transparent;
    border: var(--border-general);
    transition: var(--transition-all-03s-ease);
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
.settings-submit{
    background-color: var(--color-link);
    margin-top: 10px;
    width: fit-content;
}
</style>
