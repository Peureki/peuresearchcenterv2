<template>
    <div class="content-section">
        <h3>Legend</h3>
        <!-- 
            *
            * LEGENDS BOX
            *
        -->
        <p class="small-subtitle">This page heavily utilizies the <span @click="settingsToggle = !settingsToggle" class="link">Settings (Buy Order & Sell Order)</span>.</p>

        <div class="legend">
            <div class="img-and-label">
                <svg @click="settingsToggle = !settingsToggle"  class="icon clickable" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.5 14.146C9.53308 14.146 8.60575 13.7619 7.92202 13.0782C7.2383 12.3944 6.85418 11.4671 6.85418 10.5002C6.85418 9.53323 7.2383 8.6059 7.92202 7.92217C8.60575 7.23845 9.53308 6.85433 10.5 6.85433C11.467 6.85433 12.3943 7.23845 13.078 7.92217C13.7617 8.6059 14.1458 9.53323 14.1458 10.5002C14.1458 11.4671 13.7617 12.3944 13.078 13.0782C12.3943 13.7619 11.467 14.146 10.5 14.146ZM18.2396 11.5106C18.2813 11.1772 18.3125 10.8439 18.3125 10.5002C18.3125 10.1564 18.2813 9.81267 18.2396 9.4585L20.4375 7.76058C20.6354 7.60433 20.6875 7.32308 20.5625 7.09391L18.4792 3.48975C18.3542 3.26058 18.0729 3.16683 17.8438 3.26058L15.25 4.30225C14.7083 3.896 14.1458 3.54183 13.4896 3.28142L13.1042 0.520998C13.083 0.398308 13.0191 0.287068 12.9238 0.206989C12.8285 0.126911 12.7079 0.083163 12.5833 0.083498H8.41668C8.15627 0.083498 7.93752 0.270998 7.89585 0.520998L7.51043 3.28142C6.85418 3.54183 6.29168 3.896 5.75002 4.30225L3.15627 3.26058C2.9271 3.16683 2.64585 3.26058 2.52085 3.48975L0.437516 7.09391C0.302099 7.32308 0.364599 7.60433 0.562516 7.76058L2.76043 9.4585C2.71877 9.81267 2.68752 10.1564 2.68752 10.5002C2.68752 10.8439 2.71877 11.1772 2.76043 11.5106L0.562516 13.2397C0.364599 13.396 0.302099 13.6772 0.437516 13.9064L2.52085 17.5106C2.64585 17.7397 2.9271 17.8231 3.15627 17.7397L5.75002 16.6877C6.29168 17.1043 6.85418 17.4585 7.51043 17.7189L7.89585 20.4793C7.93752 20.7293 8.15627 20.9168 8.41668 20.9168H12.5833C12.8438 20.9168 13.0625 20.7293 13.1042 20.4793L13.4896 17.7189C14.1458 17.4481 14.7083 17.1043 15.25 16.6877L17.8438 17.7397C18.0729 17.8231 18.3542 17.7397 18.4792 17.5106L20.5625 13.9064C20.6875 13.6772 20.6354 13.396 20.4375 13.2397L18.2396 11.5106Z" fill="var(--color-link)"/>
                    <title>Settings</title>
                </svg>
                <a class="link" @click="settingsToggle = !settingsToggle">Settings</a>
            </div>

            <!-- <div class="img-and-label">
                <svg @click="filtersToggle = !filtersToggle" class="icon clickable" width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.0001 9V16.88C10.0401 17.18 9.94013 17.5 9.71013 17.71C9.61762 17.8027 9.50773 17.8763 9.38675 17.9264C9.26578 17.9766 9.1361 18.0024 9.00513 18.0024C8.87416 18.0024 8.74448 17.9766 8.62351 17.9264C8.50253 17.8763 8.39264 17.8027 8.30013 17.71L6.29013 15.7C6.18107 15.5934 6.09814 15.463 6.04783 15.319C5.99752 15.175 5.9812 15.0213 6.00013 14.87V9H5.97013L0.210131 1.62C0.0477393 1.41153 -0.0255351 1.14726 0.00631899 0.88493C0.0381731 0.622602 0.172566 0.383546 0.380131 0.22C0.570131 0.08 0.780131 0 1.00013 0H15.0001C15.2201 0 15.4301 0.08 15.6201 0.22C15.8277 0.383546 15.9621 0.622602 15.9939 0.88493C16.0258 1.14726 15.9525 1.41153 15.7901 1.62L10.0301 9H10.0001Z" fill="var(--color-link)"/>
                    <title>Filters</title>
                </svg>
                <a class="link" @click="filtersToggle = !filtersToggle">Filters</a>
            </div> -->

            <div class="img-and-label">
                <svg 
                    class="icon" 
                    width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                >
                    <rect 
                        class="fill-rect" 
                        x="0" y="0" width="20" height="20" 
                        fill="var(--color-rarity-exotic)" 
                        stroke-width="1" 
                    />
                </svg>
                <p>Day only farm</p> 
            </div>

            <div class="img-and-label">
                <svg 
                    class="icon" 
                    width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                >
                    <rect 
                        class="fill-rect" 
                        x="0" y="0" width="20" height="20" 
                        fill="var(--color-rarity-legendary)" 
                        stroke-width="1" 
                    />
                </svg>
                <p>Night only farm</p> 
            </div>

            <div class="img-and-label">
                <svg 
                    class="icon" 
                    width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                >
                    <circle class="fill-circle" cx="10" cy="10" r="10" fill="var(--color-up)" stroke-width="1" />
                </svg>
                <p>Fish farm available now</p> 
            </div>

            <div class="img-and-label">
                <svg 
                    class="icon" 
                    width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                >
                    <circle class="fill-circle" cx="10" cy="10" r="10" fill="var(--color-down)" stroke-width="1" />
                </svg>
                <p>Fish farm unavailable now</p> 
            </div>

            <div class="img-and-label">
                <svg class="icon" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 0C11.2311 0 8.52431 0.821086 6.22202 2.35943C3.91973 3.89777 2.12532 6.08427 1.06569 8.64243C0.00606596 11.2006 -0.271181 14.0155 0.269012 16.7313C0.809205 19.447 2.14258 21.9416 4.10051 23.8995C6.05845 25.8574 8.55301 27.1908 11.2687 27.731C13.9845 28.2712 16.7994 27.9939 19.3576 26.9343C21.9157 25.8747 24.1022 24.0803 25.6406 21.778C27.1789 19.4757 28 16.7689 28 14C28 10.287 26.525 6.72601 23.8995 4.1005C21.274 1.475 17.713 0 14 0ZM26 13H20C19.8833 9.31709 18.9291 5.70915 17.21 2.45C19.5786 3.0979 21.6914 4.45684 23.2632 6.34342C24.8351 8.23 25.7903 10.5534 26 13ZM14 26C13.7769 26.015 13.5531 26.015 13.33 26C11.2583 22.6962 10.1085 18.8981 10 15H18C17.9005 18.8953 16.7612 22.6932 14.7 26C14.467 26.0164 14.2331 26.0164 14 26ZM10 13C10.0995 9.10468 11.2388 5.30682 13.3 2C13.7453 1.94997 14.1947 1.94997 14.64 2C16.7223 5.3008 17.8825 9.09906 18 13H10ZM10.76 2.45C9.0513 5.71164 8.10746 9.31945 8.00001 13H2.00001C2.20971 10.5534 3.16495 8.23 4.7368 6.34342C6.30865 4.45684 8.42144 3.0979 10.79 2.45H10.76ZM2.05001 15H8.05001C8.15437 18.6798 9.09478 22.2875 10.8 25.55C8.43887 24.8951 6.33478 23.5332 4.77056 21.6472C3.20634 19.7612 2.25695 17.4415 2.05001 15ZM17.21 25.55C18.9291 22.2908 19.8833 18.6829 20 15H26C25.7903 17.4466 24.8351 19.77 23.2632 21.6566C21.6914 23.5432 19.5786 24.9021 17.21 25.55Z" fill="var(--color-link)"/>
                    <title>Wiki</title>
                </svg>
                <p>View item from <a href="https://wiki.guildwars2.com/wiki/Main_Page" target="_blank">Wiki</a> page</p>
            </div>

            <div class="img-and-label">
                <svg class="icon rotate-neg-45" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-link)"/>
                </svg>
                <p>Expand for details</p>
            </div>
        </div>
        <!-- 
            *
            * EXAMPLE RESEARCH NOTE CARD
            *
        -->
        <div class="card-container">
            <div class="card">
                <img class="card-main-icon" :src="UnholyMackerel" alt="Most profitable item in the farm" title="Most profitable item in the farm">

                <div class="card-details">
                    <span class="card-title-and-value">
                        <span class="title-container">
                            <p class="title daytime">Fishing Hole</p>

                            <svg 
                                class="icon" 
                                width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                            >
                                <circle class="fill-circle" cx="10" cy="10" r="10" fill="var(--color-up)" stroke-width="1" />
                            </svg>

                            <p>(Active/Inactive)</p>
                        </span>

                        <p>{ Value }</p>
                    </span>

                    <span class="card-map-and-info">
                        <p class="map-and-info">{ Map, Region }</p>

                        <span class="card-info-container">
                            <img class="bait" :src="Shrimpling" alt="Bait" title="Bait">
                            <p>(Bait)</p>
                            <p>{ Fishing Power }</p>
                            <p>{ Time of Day }</p>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import UnholyMackerel from '@/imgs/icons/fishes/Unholy_Mackerel.png'
import Shrimpling from '@/imgs/icons/Shrimpling.png'

import { buyOrder, settingsToggle, filtersToggle } from '@/js/vue/composables/Global';

</script>