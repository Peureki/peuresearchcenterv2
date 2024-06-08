<template>
    
    <router-view></router-view>
</template>

<script setup>

</script>


<style>
/*
 *
 * GLOBAL STYLES
 *
 */
@import url('https://fonts.googleapis.com/css2?family=Rubik&display=swap');

* {
    box-sizing: border-box;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    font-kerning: auto;
}
*::before,
*::after{
    box-sizing: border-box;
}
html {
    font-family: sans-serif;
    -webkit-text-size-adjust: 100%;
    overflow-x: hidden;
}
body {
    margin: 0;
    position: relative;
    background-color: var(--color-bkg);
}
html, body{
    height: 100%;
    scroll-behavior: smooth;
}

h1, h2, h3, h4, h5, h6, p, label, button, input, span{
    font-family: var(--font-family);
    color: var(--color-text);
    margin: 0;
}
input {
    color: var(--color-black);
    background-color: var(--color-input-bkg);
    border: none;
    padding: var(--padding-input);
}
a {
    cursor: pointer;
}

h1{
    color: var(--color-h1);
    font-size: var(--font-size-h1);
}
h3{
    color: var(--color-subheader);
    font-size: var(--font-size-h3);
}
h4{
    color: var(--color-text);
    font-size: var(--font-size-h4);
    margin: 0;
    font-weight: normal;
}
h5{
    color: var(--color-text);
    font-size: var(--font-size-h5);
    padding: var(--padding-h5);
    margin: 0;
    font-weight: normal;
    text-align: center;
}
h6{
    font-size: var(--font-size-h6);
    margin: 0;
    font-weight: normal;
}
p, label, input, button {
    font-size: var(--font-size-p);
}
p {
    line-height: 1.3;
}
ul {
    margin: 0;
}
li {
    font-family: var(--font-family);
    font-size: var(--font-size-p);
    color: var(--color-text);
    list-style: none;
}
table, th, td{
    border: var(--border-general);
    border-collapse: collapse;
}
button {
    color: var(--color-black);
    border: none;
    cursor: pointer;
    background-color: var(--color-link);
    padding: var(--padding-button);
}
article {
    padding: var(--padding-article);
}

nav h6{
    white-space: nowrap;
}

nav{
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0;
    left: 0;
    height: 100dvh;
    overflow-x: hidden;
    overflow-y: scroll;
    width: var(--nav-width);
    background-color: var(--color-bkg);
    /* padding-left: var(--nav-padding); */
    z-index: 100000;
}
::-webkit-scrollbar{
    width: 1rem;
    border: var(--border-general);
}
::-webkit-scrollbar-thumb{
    background-color: var(--color-scrollbar-thumb);
}
nav .top img{
    width: var(--nav-img-w-and-h);
    height: var(--nav-img-w-and-h);
}
nav .logo-container{
    width: 100%;
}
nav .credits p{
    padding-left: var(--nav-padding-left);
}
nav .shortcuts {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--padding-shortcuts);
    border-bottom: var(--border-bottom);
}
nav .shortcuts .left,
nav .shortcuts .middle,
nav .shortcuts .right{
    width: 100%;
    display: flex;
    align-items: center;
    gap: 10px;
}
nav .shortcuts .left{
    justify-content: flex-start;
}
nav .shortcuts .middle{
    justify-content: center;
}
nav .shortcuts .right{
    justify-content: flex-end;
}
nav .shortcuts svg{
    cursor: pointer;
}
nav .shortcuts #cog:hover{
    transform: rotate(180deg);
    transition: all 0.5s ease;
}
nav header {
    position: relative;
    cursor: pointer;
    border-bottom: var(--border-bottom);
}
nav header svg{
    position: absolute;
    bottom: 5%;
    left: 50%;
    transform: translate(-5%, -50%);
    width: 10px;
    height: 10px;
    transition: var(--transition-all-03s-ease);
}
nav header:hover svg{
    bottom: 0%;
    transform: translate(0%, -50%);
}

a.page-link{
    display: flex;
    align-items: center;
    gap: 5px;
    padding: var(--nav-padding);
    border-bottom: var(--border-bottom);
    text-decoration: none;
}
nav a img{
    width: 20px;
    height: 20px;
}
nav .routes a img,
nav .routes a h6{
    transition: var(--transition-all-03s-ease);
}

nav .routes a:hover img,
nav .routes a:hover h6{
    transform: translateX(10px);
}
nav a:hover{
    border-bottom: var(--hover-border-bottom);
}


nav section .distinquish-section{
    display: grid;
    grid-template-columns: 1fr 10fr;
}
nav section .distinquish-section .label{
    display: flex;
    align-items: center;
    justify-content: center;
    writing-mode: vertical-rl;
    transform: rotate(180deg);
    padding: var(--nav-padding-label);
}
nav section .distinquish-section .label h6{
    color: var(--color-black);
}
nav section .distinquish-section .label#core{
    background-color: var(--color-core);
}
nav section .distinquish-section .label#hot{
    background-color: var(--color-hot);
}
nav section .distinquish-section .label#ls3{
    background-color: var(--color-ls3);
}
nav section .distinquish-section .label#pof{
    background-color: var(--color-pof);
}
nav section .distinquish-section .label#ls4{
    background-color: var(--color-ls4);
}
nav section .distinquish-section .label#soto{
    background-color: var(--color-soto);
}
nav section .distinquish-section .routes{
    width: 100%;
}
nav section.nav-timer-container .outposts:hover{
    text-decoration-line: line-through;
    text-decoration-color: var(--color-text);
}


main {
    padding-left: var(--nav-width);
}
main header{
    padding: var(--padding-main);
    border-bottom: var(--border-bottom);
}

nav section.nav-timer-container{
    display: flex;
    flex-direction: column;
    justify-content: center;
}
nav section.nav-timer-container .timer{
    border-bottom: var(--border-bottom);
    transition: all 0.2s ease;
}
/* TRANSITION FOR WHEN TIMERS SWAP PLACES */
.swap{
    opacity: 0.7;
}
/* nav section.nav-timer-container article{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--padding-timers);
}
nav section.nav-timer-container svg,
nav section.nav-timer-container img{
    width: 20px;
    height: 20px;
}
nav section.nav-timer-container svg{
    cursor: pointer;
}
nav section.nav-timer-container .hidden-timer{
    display: none;
} */

/* 
 *
 * GENERAL TABLES
 *
 */
table{
    border-spacing: 0;
}
/* Only the main header at the top */
table thead tr:first-child th{
    background-color: var(--color-table-header);
}
/* Prevents the main header of the table to look selectable */
/* table tr:not(:first-child) th:hover{
    border-bottom: var(--border-bottom-link);
} */
table tr:nth-child(odd){
    background-color: #303134;
}

table thead svg{
    width: 20px;
    height: 20px;
}
table thead img {
    width: var(--font-size-h5);
    height: var(--font-size-h5);
}
table th{
    cursor: pointer;
    transition: var(--transition-all-03s-ease);
}

table thead h4{
    color: var(--color-black);
    padding: var(--padding-table-header);
}
table td{
    color: var(--color-text);
    font-size: var(--font-size-p);
    font-family: var(--font-family);
    padding: var(--padding-table-td);
    vertical-align: middle;
}

table svg{
    width: 20px;
    height: 20px;
}
table td.cta{
    cursor: pointer;
}
table td.cta span{
    display: flex;
    justify-content: center;
}
table td.cta span svg{
    transition: var(--transition-all-03s-ease);
}


table td img{
    vertical-align: middle;
    width: 20px;
    aspect-ratio: 1 / 1;
    margin-left: 2px;
}

.list-general {
    padding: var(--padding-ul-general);
}
.list-general li{
    padding: var(--padding-li-general);
}

/* 
 * GLOBAL CHECKBOXES
 */
.checkbox{
    display: flex;
    align-items: center;
    position: relative;
    width: 15px;
    height: 15px;
    padding: var(--padding-checkboxes);
}
.checkbox input[type="checkbox"]{
    width: 20px;
    height: 20px;
    opacity: 0;
    cursor: pointer;
    position: absolute;
}
.checkbox label {
    display: flex;
    white-space: nowrap;
    cursor: pointer;
}
.checkbox label:hover{
    color: var(--color-link);
}
.checkbox label::before{
    content: "";
    width: 20px;
    height: 20px;
    margin-right: 10px;
    color: var(--color-text);
    border: 1px solid var(--color-link);
}
.checkbox input[type="checkbox"]:checked + label::before{
    content: "\002714";
    display: flex;
    justify-content: center;
    align-items: center;
}

.cta-arrow{
    opacity: 0.5;
}

/* 
 * PAGE BUTTONS
 */
.page-button-container{
    display: flex;
    align-items: center;
    gap: 10px;
    padding: var(--padding-block-general);
}
.page-button-list{
    display: flex;
    gap: 10px;
}
.page-button-container button{
    display: flex;
    align-items: center;
    color: var(--color-text);
    background-color: transparent;
}
.page-button-container button:hover{
    color: var(--color-link);
}
.page-button-prev svg,
.page-button-next svg{
    width: 18px;
    height: 18px;
}
.page-button-prev svg{
    transform: rotate(180deg);
}
button.page-button-current {
    border-bottom: var(--border-bottom-link);
}
input[type="number"].specific-page{
    width: 100px;
}

/* 
 * BOOKMARKS
 */
.bookmark-container{
    background-color: transparent;
    border: none;
    padding: 0;
}
a.bookmark{
    border-bottom: none;
    padding: var(--padding-bookmark);
    text-decoration: none;
}
a.bookmark:hover{
    border-bottom: none;
}
a.bookmark:hover p{
    color: var(--color-link);
}
span.bookmark-label{
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 10px;
}

/* 
 * GENERAL FLEX DIVS
 */
.flex-row-space-btw{
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 10px;
}
.flex-row-flex-start{
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 10px;
}
.flex-row-flex-start img, 
.flex-row-flex-start svg{
    width: 20px;
    height: 20px;
    transition: var(--transition-all-03s-ease);
}
/* 
    =================================================
    * FILTER CONTAINERS 
    =================================================
*/
.filter-container{
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

/* 
 * FORM BUTTONS
 */
span.input-radio{
    display: flex;
    gap: 5px;
    background-color: var(--color-link);
    padding: var(--padding-button);
}
span.input-radio label{
    color: var(--color-black);
}
/* input[type="text"]{
    width: 300px;
} */
input[type="number"] {
    width: fit-content;
}
button.submit {
    background-color: var(--color-link);
    width: fit-content;
    padding: var(--padding-button);
}

/* 
 * TOOLTIP
 */
.tooltip{
    position: absolute;
    background-color: var(--color-bkg);
    padding: var(--padding-tooltip);
    margin: var(--margin-tooltip);
    border: var(--border-tooltip);
    z-index: 100000000000000;
}
.tooltip p{
    white-space: nowrap;
}
/* 
 * ROTATION
 */
.rotate-180 {
    transform: rotate(180deg);
}
.rotate-90{
    transform: rotate(90deg);
}
.text-right{
    text-align: right;
}
.float-right{
    float: right;
}

.sub-gold-label, .gold-label, .profit-label{
    padding-left: 3px;
}


/* 
 * ARROWS
 */
.sort-arrow{
    opacity: 0.1;
    transition: var(--transition-all-03s-ease);
}
/* 
 * ACTIVE / INACTIVE
 */
 .active{
    opacity: 1;
}


/* 
 * HOVERABLE CONTAINERS
 */
.border-is-hoverable{
    border-bottom: var(--hover-border-bottom);
}
.sortable-column{
    display: flex;
    justify-content: center;
    align-items: center;
}

/* 
 * TRANSITIONS
 */
.fade-right-enter-active {
    transition: opacity 0.2s ease, transform 0.5s ease;
}
.fade-right-leave-active{
    transition: all 0.2s ease;
}

.fade-right-enter-from,
.fade-right-leave-to {
    opacity: 0;
    transform: translateX(25px);
}

.fade-enter-active {
    transition: opacity 0.3s ease;
}
.fade-leave-active{
    transition: all 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
/* 
 * GOLD LABELS
 */
span.gold-label-container{
    display: flex;
    align-items: center;
    justify-content: flex-end;
}
span.gold-label{
    display: flex;
    align-items: flex-end;
    padding-inline: 2px;
}
span.gold-label img{
    width: 15px;
}
/* 
    =================================================
    * DYNAMIC CLASSES
    =================================================
*/
.active-button {
    opacity: 1;
    background-color: var(--color-link);
    color: var(--color-black);
    border: var(--border-hidden);
    transition: var(--transition-all-03s-ease);
    border-radius: 10px;
}
.inactive-button{
    opacity: 0.2;
    background-color: transparent;
    color: var(--color-text);
    border: var(--border-general);
    transition: var(--transition-all-03s-ease);
    border-radius: 10px;
}
.error-message{
    color: var(--color-down);
}

.event-up{
    color: var(--color-event-up);
}
.event-upcoming{
    color: var(--color-event-upcoming);
}
.event-overdue{
    color: var(--color-event-overdue);
}
.event-meta{
    color: var(--color-event-meta);
}

.border-event-up{
    border-right: var(--border-event-up);
}
.border-event-upcoming{
    border-right: var(--border-event-upcoming);
}
.border-event-overdue{
    border-right: var(--border-event-overdue);
}
.border-event-meta{
    border-right: var(--border-event-meta);
}
.border-left{
    border-left: var(--border-general);
}

:root{
    --color-bkg: #2a2b2e;
    --color-h1: #ff391b;
    --color-text: #ffffff;
    --color-link: #ffd12c;
    --color-black: #000000;
    --color-core: #f8ebb7;
    --color-hot: #5ed625;
    --color-ls3: #f75277;
    --color-pof: #ec004d;
    --color-ls4: #AF3CC9;
    --color-soto: #d3a049;
    --color-input-bkg: #ebebeb;
    --color-scrollbar-thumb: #88888a;
    --color-event-up: #5ED625;
    --color-event-upcoming: #FFB64A;
    --color-event-overdue: #EC004D; 
    --color-event-meta: #76E9E1;
    --color-table-header: #79eb94;
    --color-subheader: #79EB94;
    --color-up: #5ED625;
    --color-down: #EC004D;
    --color-positive: #11BC1E;
    --color-negative: #A56464;
    --color-positive-faded: rgb(82, 255, 0, 0.2);
    --color-negative-faded:rgb(255, 0, 0, 0.2);
    --color-rarity-fine: #4f9dfe;
    --color-rarity-masterwork: #2dc50e;
    --color-rarity-rare: #ffe51f;
    --color-rarity-exotic: #fda500;
    --color-rarity-ascended: #ff4488;
    --color-rarity-legendary: #9930e8;

    --font-size-h1: clamp(2rem, 20vw, 6.25rem);
    --font-size-h3: clamp(1.3rem, 8vw, 2rem);
    --font-size-h4: clamp(1.2rem, 7vw, 1.5rem);
    --font-size-h5: clamp(1.1rem, 5vw, 1.2rem);
    --font-size-h6: clamp(0.8rem, 4vw, 1rem);
    --font-size-p: clamp(0.8rem, 4vw, 1rem);
    --font-size-subtext: clamp(0.5rem, 3vw, 0.8rem);

    --font-family: 'Rubik', sans-serif;

    --border-general: 2px solid #3D3F42;
    --border-hidden: 2px solid rgb(95, 96, 98, 0);
    --border-bottom: 2px solid #3D3F42;
    --border-button-link: 2px solid #ffd12c;
    --border-bottom-link: 2px solid #ffd12c;
    --border-event-up: 4px solid #5ED625;
    --border-event-upcoming: 4px solid #FFB64A;
    --border-event-overdue: 4px solid #EC004D;
    --border-event-meta: 4px solid #76E9E1;
    --border-tooltip: 2px solid #3D3F42;
    --border-positive: 2px solid #5ED625;
    --border-negative: 2px solid #EC004D;
    

    --nav-width: clamp(15rem, 15vw, 18rem);
    --nav-padding: 10px 0 10px 10px;
    --nav-padding-left: 10px;
    --nav-padding-label: 5px;
    --nav-img-w-and-h: clamp(3rem, 10vw, 10rem);

    --padding-shortcuts: 10px;
    --padding-h5: 20px 10px 20px 10px;
    --padding-main: 0px 10px 0 10px;
    --padding-outpost: 10px 0px 10px 10px;
    --padding-timers: 5px;
    --padding-event-time: 0px 0px 0px 10px;
    --padding-general-10px: 10px;
    --padding-p-inline: 0px 3px 0px 3px;
    --padding-ul-general: 0px 10px 0px 10px;
    --padding-li-general: 3px 10px 3px 10px;
    --padding-checkboxes: 13px 5px 13px 5px;
    --padding-tooltip: 10px;
    --padding-table-header: 10px 10px 10px 10px;
    --padding-table-td: 10px 10px 10px 10px;
    --padding-gold-span: 0px 1px 0px 1px;
    --padding-article: 10px;
    --padding-button: 5px;
    --padding-settings: 10px;
    --padding-input: 5px;
    --padding-bookmark: 5px 0px 5px 0;
    --padding-search-li: 5px 0px 5px 10px;
    --padding-block-general: 10px 0px 10px 0px;
    

    --margin-shortcuts-svg: 0 10px 0 10px;
    --margin-tooltip: 20px 0px 0px 0px;
    --margin-gold-span: 0px 2px 0px 2px;
    --margin-block-general: 10px 0px 10px 0px;

    --transition-all-03s-ease: all 0.3s ease;

    --hover-border-bottom: 2px solid #ffd12c;
    --hover-bkg-fade: rgba(255, 209, 44, 0.2); 

    --img-timer-map-w: clamp(62.5rem, 115vw, 300rem);
}

</style>