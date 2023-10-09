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
}

h1, h2, h3, h4, h5, h6, p{
    font-family: var(--font-family);
    color: var(--color-text);
    margin: 0;
}

h1{
    color: var(--color-h1);
    font-size: var(--font-size-h1);
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
ul {
    margin: 0;
}
li {
    font-family: var(--font-family);
    font-size: var(--font-size-p);
    color: var(--color-text);
    list-style: none;
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

nav a{
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
nav a img,
nav a h6{
    transition: var(--transition-all-03s-ease);
}

nav a:hover img,
nav a:hover h6{
    transform: translateX(10px);
}
nav a:hover{
    border-bottom: var(--hover-border-bottom);
}


nav section .distinquish-maps{
    display: grid;
    grid-template-columns: 1fr 10fr;
}
nav section .distinquish-maps .label{
    display: flex;
    align-items: center;
    justify-content: center;
    writing-mode: vertical-rl;
    transform: rotate(180deg);
    padding: var(--nav-padding-label);
}
nav section .distinquish-maps .label h6{
    color: var(--color-black);
}
nav section .distinquish-maps .label#hot{
    background-color: var(--color-hot);
}
nav section .distinquish-maps .label#ls3{
    background-color: var(--color-ls3);
}
nav section .distinquish-maps .label#pof{
    background-color: var(--color-pof);
}
nav section .distinquish-maps .maps{
    width: 100%;
}
nav section.nav-timer-container .outposts:hover{
    text-decoration-line: line-through;
    text-decoration-color: var(--color-text);
}


main {
    /* padding-left: calc(var(--nav-width) + 1rem); */
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
nav section.nav-timer-container article{
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
}

.list-general {
    padding: var(--padding-ul-general);
}
.list-general li{
    padding: var(--padding-li-general);
}

.rotate180 {
    transform: rotate(180deg);
}

.fade-enter-active {
    transition: opacity 0.1s ease, transform 0.5s ease;
}
.fade-leave-active{
    transition: all 0.1s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateX(25px);
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

:root{
    --color-bkg: #2a2b2e;
    --color-h1: #ff391b;
    --color-text: #ffffff;
    --color-black: #000000;
    --color-hot: #5ed625;
    --color-ls3: #f75277;
    --color-pof: #ec004d;
    --color-scrollbar-thumb: #88888a;
    --color-event-up: #5ED625;
    --color-event-upcoming: #FFB64A;
    --color-event-overdue: #EC004D; 
    --color-event-meta: #76E9E1;

    --font-size-h1: clamp(2rem, 20vw, 6.25rem);
    --font-size-h4: clamp(1.3rem, 6vw, 2rem);
    --font-size-h5: clamp(1.2rem, 7vw, 1.5rem);
    --font-size-h6: clamp(1rem, 5vw, 1rem);

    --font-family: 'Rubik', sans-serif;

    --border-general: 2px solid #5f6062;
    --border-bottom: 2px solid #5f6062;
    --border-event-up: 4px solid #5ED625;
    --border-event-upcoming: 4px solid #FFB64A;
    --border-event-overdue: 4px solid #EC004D;
    --border-event-meta: 4px solid #76E9E1;

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
    --padding-general-10px: 10px;
    --padding-p-inline: 0px 3px 0px 3px;
    --padding-ul-general: 0px 10px 0px 10px;
    --padding-li-general: 3px 10px 3px 10px;

    --margin-shortcuts-svg: 0 10px 0 10px;

    --transition-all-03s-ease: all 0.3s ease;

    --hover-border-bottom: 2px solid #ffd12c;

    --img-timer-map-w: clamp(62.5rem, 115vw, 300rem);
}

</style>