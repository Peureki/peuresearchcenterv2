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

section{
    padding-left: calc(var(--nav-width));
    padding-block: var(--padding-section);
}
section.main{
    padding-left: calc(var(--nav-width) + var(--nav-padding-left));
}
header {
    padding-left: calc(var(--nav-width) + var(--nav-padding-left));
}

nav h6{
    white-space: nowrap;
}

/* 
    =================================================
    * MOBILE FOR HTML SYMATIC STUFF
    =================================================
*/
@media (max-width: 768px){
    section, section.main{
        padding-left: unset;
        padding: var(--padding-mobile-general);
    }
    header{
        padding-left: unset;
        padding: var(--padding-mobile-general);
        padding-top: calc(var(--padding-general) * 2 + 60px);
    }
    .overflow-table{
        overflow-x: auto;
    }
}

a.page-link{
    display: flex;
    align-items: center;
    gap: 5px;
    padding: var(--nav-padding);
    border-bottom: var(--border-bottom);
    text-decoration: none;
}

.icon{
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.distinquish-section{
    display: grid;
    grid-template-columns: 1fr 10fr;
}
.distinquish-section .label{
    display: flex;
    align-items: center;
    justify-content: center;
    writing-mode: vertical-rl;
    transform: rotate(180deg);
    padding: var(--nav-padding-label);
}
.distinquish-section .label h6{
    color: var(--color-black);
}
.distinquish-section .label#core{
    background-color: var(--color-core);
}
.distinquish-section .label#hot{
    background-color: var(--color-hot);
}
.distinquish-section .label#ls3{
    background-color: var(--color-ls3);
}
.distinquish-section .label#pof{
    background-color: var(--color-pof);
}
.distinquish-section .label#ls4{
    background-color: var(--color-ls4);
}
.distinquish-section .label#soto{
    background-color: var(--color-soto);
}
.distinquish-section .label#eod{
    background-color: var(--color-eod);
}
.distinquish-section .routes{
    width: 100%;
}
nav-timer-container .outposts:hover{
    text-decoration-line: line-through;
    text-decoration-color: var(--color-text);
}




nav-timer-container{
    display: flex;
    flex-direction: column;
    justify-content: center;
}
nav-timer-container .timer{
    border-bottom: var(--border-bottom);
    transition: all 0.2s ease;
}
/* TRANSITION FOR WHEN TIMERS SWAP PLACES */
.swap{
    opacity: 0.7;
}
/* nav-timer-container article{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--padding-timers);
}
nav-timer-container svg,
nav-timer-container img{
    width: 20px;
    height: 20px;
}
nav-timer-container svg{
    cursor: pointer;
}
nav-timer-container .hidden-timer{
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
table .table-header{
    padding: var(--padding-table-header)
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
    gap: var(--gap-general);
    cursor: pointer;
}
.checkbox label img{
    width: var(--img-material-w);
}
.checkbox label:hover{
    color: var(--color-link);
}
.checkbox label::before{
    content: "";
    width: 20px;
    height: 20px;
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
input.small-number-field{
    width: 75px;
    max-width: 100px;
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
.rotate-neg-45 {
    transform: rotate(-45deg);
}
.rotate-45{
    transform: rotate(45deg);
}
.text-left{
    display: flex;
    gap: 5px;
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

/* FADE DOWN */
.fade-down-enter-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-down-leave-active{
    transition: all 0.3s ease;
}

.fade-down-enter-from,
.fade-down-leave-to {
    opacity: 0;
    transform: translateY(-500px);
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
    font-size: var(--font-size-p);
}
span.gold-label img{
    width: 15px;
}
span.label-and-subtitle{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
.small-subtitle{
    font-size: var(--font-size-subtext);
    font-style: italic;
    color: var(--color-text-fade);
}
@media (max-width: 768px){
    span.gold-label img{
        width: 13px;
    }
}
/* 
    =================================================
    * GENERAL CLASSES
    =================================================
*/
.flex{
    display: flex;
    align-items: center;
    gap: var(--gap-general);
}
.two-col-container{
    display: flex;
    align-items: flex-start;
    gap: var(--gap-content);
}
/* 
    =================================================
    * CHARTS AND GRAPHS
    =================================================
*/
.pie-chart {
    display: flex;
    flex-direction: column;
    gap: var(--gap-content);
    position: relative;
}
@media (max-width: 768px){
    .pie-chart{
        display: none;
    }
}
/* 
    =================================================
    * DETAILS CONTAINER
    =================================================
*/
.details-container{
    display: flex;
    gap: var(--gap-content);
}
/* 
    =================================================
    * PROOF CONTAINERS
    * Showcase proofs of drops or data
    =================================================
*/
.proof-container{
    display: flex;
    flex-direction: column;
    gap: var(--gap-content);
}
.proof{
    display: flex;
    justify-content: space-between;
    gap: var(--gap-general);
}
.calculations{
    display: flex;
    align-items: flex-start;
    gap: var(--gap-general);
}
.written-calculations{
    display: flex;
    flex-direction: column;
}
span.currency{
    display: flex;
    gap: var(--gap-general);
}
span.currency img{
    width: 20px;
    height: 20px;
}

/* 
    =================================================
    * SEARCH QUERIES
    =================================================
*/

.search-query-container{
    display: flex;
    flex-direction: column;
    margin: var(--margin-block-general);
    padding: 0;
    height: fit-content;
    max-height: 200px;
    overflow-y: auto;
}
.search-query-container li:hover{
    background-color: var(--hover-bkg-fade);
}
.search-query-container li{
    display: flex;
    align-items: center;
    gap: 5px;
    padding: var(--padding-search-li);
}
.search-query-container li img{
    width: 20px;
    height: 20px;
}
.search-query-container button{
    border: none;
    background-color: unset;
    padding: 0;
}
.search-query-container button:focus{
    outline: none;
    background-color: var(--hover-bkg-fade);
}
.recipe-form{
    display: flex;
    justify-content: center;
    flex-direction: column;
    gap: 5px;
    width: fit-content;
}
.display-output-container{
    display: flex;
    flex-direction: column;
    width: fit-content;
    gap: 5px;

}
span.output{
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 50px;
}

/* 
    =================================================
    * SUPPORT
    =================================================
*/
.support{
    position: relative;
}
button.support-button{
    display: flex;
    flex-wrap: nowrap;
    gap: var(--gap-content);
    animation-name: marquee;
    animation-duration: 45s;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
}
button.support-button p{
    color: var(--color-black);
    white-space: nowrap;
}
img.rolling-choya{
    width: var(--svg-icon-size);
    height: var(--svg-icon-size);
    animation-name: rollingChoya;
    animation-duration: 1.5s;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
}
@keyframes rollingChoya {
    from {transform: rotate(0deg);}
    to {transform: rotate(-360deg);}
}
@keyframes marquee{
    from {transform: translateX(0);}
    to {transform: translateX(-50%)}
}


/* 
    =================================================
    * SVGS
    =================================================
*/
.icons {
    display: flex;
    align-items: center;
    gap: var(--gap-general);
}

svg.close,
svg.plus,
svg.expand,
svg.save,
svg.import,
svg.wiki {
    width: 15px;
    height: 15px;
    cursor: pointer;
    transition: var(--transition-all-03s-ease);
}

svg.save,
svg.import {
    width: 20px;
    height: 20px;
    cursor: pointer;
    transition: var(--transition-all-03s-ease);
}

/* 
    =================================================
    * BENCHMARKS
    =================================================
*/

.benchmark-grid{
    display: flex;
    flex-direction: column;
    width: fit-content;
    gap: var(--gap-general);
}
.benchmark-card{
    position: relative;
    display: flex;
    flex-direction: column;
    border: 1px solid #686868;
    padding: var(--padding-benchmark-container);
    border-radius: 5px;
    background-color: var(--color-bkg-fade);
    gap: var(--gap-content);
    transition: var(--transition-all-03s-ease);
}
p.rank{
    position: absolute;
    font-size: var(--font-size-h4);
    top: 2%;
    left: 1%;
    transform: translate(-1%, -2%);
    opacity: 0.5;
    z-index: 3;
}
.benchmark-card-container{
    position: relative;
    display: flex;
    gap: var(--gap-general);
    width: 100%;
    z-index: 2;
}

.benchmark-card:hover{
    border: 1px solid var(--color-link);
}
.benchmark-details{
    display: flex;
    width: 100%;
    flex-direction: column;
    justify-content: space-between;
    gap: var(--gap-benchmarks);
}
.benchmark-title-and-value{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
img.most-valued-icon{
    height: 100%;
    max-height: 75px;
    max-width: 75px;
}
.benchmark-value{
    font-size: var(--font-size-h5);
}
.title-container{
    display: flex;
    align-items: center;
    gap: var(--gap-general);
}
.title {
    font-size: var(--font-size-h4);
}
.benchmark-map-and-info{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 50px;
}
.map-and-info{
    white-space: nowrap;
}

.benchmark-info-container{
    display: flex;
    align-items: center;
    gap: var(--gap-general);
}
img.bait{
    width: 20px;
    height: 20px;
}
.benchmark-currencies{
    display: flex;
    gap: 3px;
}

img.benchmark-currency,
svg.sun,
svg.moon,
svg.arrow{
    width: 20px;
    height: 20px;
}
svg.arrow {
    cursor: pointer;
    /* transform: rotate(-45deg); */
    transition: var(--transition-all-03s-ease);
}
svg.arrow path{
    fill: var(--color-link);
}
.fishing-power{
    display: flex;
    align-items: center;
    gap: 5px;
}
@media (max-width: 768px){
    .benchmark-grid{
        width: 100%;
    }
    .benchmark-details{
        flex-direction: unset;
        align-items: center;
    }
    img.most-valued-icon{
        height: 40px;
        width: 40px;
    }
    /* .benchmark-info-container{
        display: none;
    } */
    img.benchmark-currency{
        width: 20px;
    }
    .benchmark-details{
        gap: var(--gap-general);
    }
    .benchmark-title-and-value{
        flex-direction: column;
        align-items: flex-start;
        gap: var(--gap-general);
    }
    .benchmark-map-and-info{
        height: 100%;
        align-items: flex-start;
        gap: var(--gap-general);
        flex-direction: column;
    }
    .benchmark-currencies{
        display: none;
    }
    .benchmark-info-container{
        width: 100%;
        justify-content: flex-end;
    }
    .map-and-info{
        white-space: unset;
    }
    p.rank{
        top: 0;
        transform: translate(-1%, 0);
    }
}



.formula {
    display: flex;
    text-align: right;
    gap: 3px;
}
.mobile-benchmark-details-container{
    display: flex;
    flex-direction: column;
    width: 100%;
    gap: 5px;
}
.mobile-info-container{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.mobile-drops-container{
    display: grid;
    grid-template-areas: 
        'name name name'
        'dr dr gph'
    ;
    gap: 5px;
    border-radius: var(--border-radius-card);
    background-color: var(--color-bkg-more-fade);
    padding: var(--gap-general);
    border: var(--border-bottom);
}
.img-and-label{
    display: flex;
    align-items: center;
    gap: var(--gap-general);
    grid-area: name;
}
.img-and-label > img{
    width: var(--img-header);
    height: var(--img-header);
}
.svg-ctas{
    display: flex;
    align-items: center;
    gap: var(--gap-general);
}
.drop-rate{
    grid-area: dr;
}
.item-name{
    font-size: var(--font-size-h6);
}
.mobile-drops-container > .gold-label-container{
    grid-area: gph;
    text-align: right;
}
.mobile-currency-container{
    display: flex;
    flex-direction: column;
    width: fit-content;
    gap: var(--gap-general);
}
.mobile-currency-card{
    display: flex;
    flex-direction: column;
    gap: var(--gap-general);
    background-color: var(--color-bkg-fade);
    padding: var(--gap-general);
    border-radius: var(--border-radius-card);
    border: var(--border-general);
}

.label-and-cta{
    display: flex;
    gap: var(--gap-content);
    grid-area: name;
    justify-content: space-between;
}
.value-container{
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--gap-content);
}
.value-conversion{
    display: flex;
    gap: var(--gap-operators);
    align-items: center;
}

@media (max-width: 768px){
    .mobile-currency-container{
        width: 100%;
    }
}



/* 
    =================================================
    * DYNAMIC CLASSES
    =================================================
*/
.strikethrough{
    text-decoration: line-through;
    color: var(--color-text-fade);
}

.active-arrow{
    transform: rotate(45deg);
}
.inactive-arrow{
    transform: rotate(-45deg);
}

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
    --color-bkg-fade: #2F3034;
    --color-bkg-more-fade: #2a2b2e;
    --color-h1: #ff391b;
    --color-text: #ffffff;
    --color-text-fade: #d1d1d1;
    --color-text-dark-fade: #9195a0;
    --color-link: #ffd12c;
    --color-black: #000000;
    --color-core: #f8ebb7;
    --color-hot: #5ed625;
    --color-ls3: #f75277;
    --color-pof: #ec004d;
    --color-ls4: #AF3CC9;
    --color-eod: #17cbb7;
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
    --color-rarity-junk: #aaaaaa;
    --color-rarity-basic: #ffffff; 
    --color-rarity-fine: #4f9dfe;
    --color-rarity-masterwork: #2dc50e;
    --color-rarity-rare: #ffe51f;
    --color-rarity-exotic: #fda500;
    --color-rarity-ascended: #ff4488;
    --color-rarity-legendary: #9930e8;
    --color-type-repeatable: #dd55da;
    --color-type-daily: #7be393;
    --color-type-node: #ef9a1f;
    --color-type-solo: #42b0f3;
    --color-dusk: #db8b9d;
    --color-dawn: #db8b9d;
    --color-anytime: #e15e6c;

    --font-size-h1: clamp(2rem, 5.5vw, 6.25rem);
    --font-size-h2: clamp(1.8rem, 15vw, 4rem);
    --font-size-h3: clamp(1.3rem, 8vw, 2rem);
    --font-size-h4: clamp(1.3rem, 1.2vw, 1.7rem);
    --font-size-h5: clamp(1.0rem, 1.1vw, 1.5rem);
    --font-size-h6: clamp(1.2rem, 1.1vw, 2rem);
    --font-size-p: clamp(1rem, 1vw, 1.1rem);
    --font-size-subtext: clamp(0.5rem, 3vw, 0.8rem);

    --gap-general: clamp(0.6rem, 0.4vw, 1rem);
    --gap-content: clamp(0.8rem, 1.5vw, 2rem);
    --gap-operators: clamp(0.3rem, 0.5vw, 1rem);
    --gap-benchmarks: clamp(0.5rem, 0.5vw, 0.8rem);

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
    --border-radius-card: 5px;
    
    --nav-width: clamp(13.5rem, 15vw, 16rem);
    --nav-padding: 10px 0 10px 10px;
    --nav-padding-left: 10px;
    --nav-padding-label: 5px;
    --nav-img-w-and-h: clamp(3rem, 10vw, 10rem);

    --padding-section: clamp(0.5rem, 0.5vw, 1.5rem);
    --padding-section-left: clamp(0.5rem, 1vw, 1.5rem);
    --padding-benchmark-container: clamp(0.5rem, 0.6vw, 1rem);
    --padding-shortcuts: 10px;
    --padding-h5: 20px 10px 20px 10px;
    --padding-table-header: clamp(0.5rem, 1vw, 1rem);
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
    --padding-table-td: 10px 10px 10px 10px;
    --padding-gold-span: 0px 1px 0px 1px;
    --padding-article: 10px;
    --padding-button: 5px;
    --padding-settings: 10px;
    --padding-input: 5px;
    --padding-bookmark: 5px 0px 5px 0;
    --padding-search-li: 5px 0px 5px 10px;
    --padding-block-general: 10px 0px 10px 0px;
    --padding-inline: clamp(0.2rem, 0.4vw, 1rem);
    --padding-mobile-general: 10px;
    --padding-general: clamp(0.6rem, 0.7vw, 1rem);

    --img-material-w: 20px;
    --img-header: clamp(1.5rem, 2vw, 3rem);

    --svg-expand: clamp(0.8rem, 0.9vw, 1.5rem);
    --svg-icon-size: clamp(1.2rem, 1.5vw, 1.30rem);
    

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