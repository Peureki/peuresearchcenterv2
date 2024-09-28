<template>
    <!-- 
        * PRIMARY ITEM 
        * Display only on the first iteration, before any recursion so it can display at the top
    -->


    <div 
        v-if="recursionLevel == 0"
        class="primary-item"
    >
        <div class="checkbox">
            <input 
                type="checkbox" 
                :name="entry.name" 
                v-model="entry.checked"
                @change="
                    checkSubBoxes(entry, entry.checked);
                    $emit('handleUnsavedChanges', true);
                ">
                
            <label :for="entry.name">
                <img v-if="entry.icon" :src="entry.icon" :alt="entry.name" :title="entry.name">
                <p :class="checkFade(entry.checked)">{{ entry.count }} {{ entry.name }}</p>
            </label> 
        </div>
        
        <div class="icon-container">
            <div class="icons">
                <svg 
                    v-if="entry.ingredients"
                    class="icon clickable expand" 
                    :class="rotate(entry.ingredients[0].expand)"
                    @click="expandSubIngredients(entry)"
                    width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M8.81372 0.397634C8.6944 0.280464 8.5326 0.214642 8.36389 0.214642C8.19519 0.214642 8.03339 0.280464 7.91407 0.397634L4.76468 3.49138L1.61529 0.397634C1.49529 0.283785 1.33457 0.220788 1.16775 0.222212C1.00093 0.223636 0.841356 0.289367 0.723392 0.405247C0.605428 0.521127 0.538516 0.677885 0.537066 0.841758C0.535617 1.00563 0.599746 1.16351 0.715642 1.28138L4.31486 4.81701C4.43417 4.93418 4.59597 5 4.76468 5C4.93339 5 5.09519 4.93418 5.2145 4.81701L8.81372 1.28138C8.93299 1.16418 9 1.00524 9 0.839509C9 0.673781 8.93299 0.514838 8.81372 0.397634Z" fill="#FFD12C"/>
                    <title>Expand</title>
                </svg>

                <svg 
                    class="icon clickable" 
                    @click="entry.primaryAddCustomEntry = !entry.primaryAddCustomEntry"
                    :class="activeButton(entry.primaryAddCustomEntry)"
                    width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.8436 1.42344C13.5373 0.865625 12.8061 0.5 11.9998 0.5C11.1936 0.5 10.4623 0.865625 10.1561 1.42344L2.65608 14.9234L0.156078 19.4234C-0.268922 20.1875 0.212329 21.0641 1.23108 21.3828C2.24983 21.7016 3.41858 21.3406 3.84358 20.5766L5.83108 17H18.1623L20.1498 20.5766C20.5748 21.3406 21.7436 21.7016 22.7623 21.3828C23.7811 21.0641 24.2623 20.1875 23.8373 19.4234L21.3373 14.9234L13.8373 1.42344H13.8436ZM16.4998 14H7.49983L11.9998 5.9L16.4998 14Z" fill="#FFD12C"/>
                    <title>Add Custom Entry</title>
                </svg>


                <svg 
                    @click="entry.primarySearchItemToggle = !entry.primarySearchItemToggle"
                    class="icon clickable" 
                    :class="activeButton(entry.primarySearchItemToggle)"
                    width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M18.2497 3.64508e-09H12.2497C12.1348 -1.13191e-05 12.0215 0.0263566 11.9185 0.0770702C11.8154 0.127784 11.7254 0.201488 11.6553 0.2925L5.65532 8.09344L4.7497 7.18969C4.61039 7.05022 4.44495 6.93958 4.26286 6.8641C4.08076 6.78861 3.88557 6.74976 3.68845 6.74976C3.49132 6.74976 3.29613 6.78861 3.11404 6.8641C2.93194 6.93958 2.76651 7.05022 2.6272 7.18969L1.43751 8.38031C1.29818 8.5196 1.18766 8.68498 1.11226 8.86699C1.03686 9.049 0.998047 9.24408 0.998047 9.44109C0.998047 9.63811 1.03686 9.83319 1.11226 10.0152C1.18766 10.1972 1.29818 10.3626 1.43751 10.5019L3.31251 12.3769L0.687508 15.0019C0.548184 15.1412 0.437664 15.3065 0.36226 15.4886C0.286857 15.6706 0.248047 15.8656 0.248047 16.0627C0.248047 16.2597 0.286857 16.4548 0.36226 16.6368C0.437664 16.8188 0.548184 16.9841 0.687508 17.1234L1.8772 18.3122C2.15847 18.5933 2.53985 18.7512 2.93751 18.7512C3.33516 18.7512 3.71654 18.5933 3.99782 18.3122L6.62282 15.6872L8.49782 17.5622C8.63713 17.7017 8.80256 17.8123 8.98466 17.8878C9.16676 17.9633 9.36195 18.0021 9.55907 18.0021C9.75619 18.0021 9.95138 17.9633 10.1335 17.8878C10.3156 17.8123 10.481 17.7017 10.6203 17.5622L11.81 16.3716C11.9493 16.2323 12.0599 16.0669 12.1353 15.8849C12.2107 15.7029 12.2495 15.5078 12.2495 15.3108C12.2495 15.1138 12.2107 14.9187 12.1353 14.7367C12.0599 14.5547 11.9493 14.3893 11.81 14.25L10.9063 13.3463L18.7072 7.34625C18.7985 7.276 18.8723 7.18567 18.923 7.08227C18.9738 6.97887 19 6.86517 18.9997 6.75V0.75C18.9997 0.551088 18.9207 0.360322 18.78 0.21967C18.6394 0.0790178 18.4486 3.64508e-09 18.2497 3.64508e-09ZM2.93938 17.25L1.7497 16.0613L4.3747 13.4363L5.56345 14.625L2.93938 17.25ZM9.55907 16.5L2.4997 9.44156L3.69032 8.25L10.7497 15.3103L9.55907 16.5ZM17.4997 6.38062L9.83657 12.2756L8.81095 11.25L13.5303 6.53063C13.6709 6.38989 13.7499 6.19907 13.7498 6.00014C13.7497 5.8012 13.6706 5.61045 13.5299 5.46984C13.3891 5.32924 13.1983 5.2503 12.9994 5.25038C12.8004 5.25047 12.6097 5.32958 12.4691 5.47031L7.7497 10.1887L6.72501 9.16313L12.6191 1.5H17.4997V6.38062Z" fill="#FFD12C"/>
                    <title>Add Item</title>
                </svg>
                <svg 
                    @click="entry.primarySearchRecipeToggle = !entry.primarySearchRecipeToggle"
                    class="icon clickable"
                    :class="activeButton(entry.primarySearchRecipeToggle)"
                    width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M13 5.9V4.2C13.55 3.96667 14.1127 3.79167 14.688 3.675C15.2633 3.55833 15.8673 3.5 16.5 3.5C16.9333 3.5 17.3583 3.53333 17.775 3.6C18.1917 3.66667 18.6 3.75 19 3.85V5.45C18.6 5.3 18.1957 5.18767 17.787 5.113C17.3783 5.03833 16.9493 5.00067 16.5 5C15.8667 5 15.2583 5.07933 14.675 5.238C14.0917 5.39667 13.5333 5.61733 13 5.9ZM13 11.4V9.7C13.55 9.46667 14.1127 9.29167 14.688 9.175C15.2633 9.05833 15.8673 9 16.5 9C16.9333 9 17.3583 9.03333 17.775 9.1C18.1917 9.16667 18.6 9.25 19 9.35V10.95C18.6 10.8 18.1957 10.6873 17.787 10.612C17.3783 10.5367 16.9493 10.4993 16.5 10.5C15.8667 10.5 15.2583 10.575 14.675 10.725C14.0917 10.875 13.5333 11.1 13 11.4ZM13 8.65V6.95C13.55 6.71667 14.1127 6.54167 14.688 6.425C15.2633 6.30833 15.8673 6.25 16.5 6.25C16.9333 6.25 17.3583 6.28333 17.775 6.35C18.1917 6.41667 18.6 6.5 19 6.6V8.2C18.6 8.05 18.1957 7.93733 17.787 7.862C17.3783 7.78667 16.9493 7.74933 16.5 7.75C15.8667 7.75 15.2583 7.82933 14.675 7.988C14.0917 8.14667 13.5333 8.36733 13 8.65ZM5.5 12C6.28333 12 7.046 12.0877 7.788 12.263C8.53 12.4383 9.26733 12.7007 10 13.05V3.2C9.31667 2.8 8.59167 2.5 7.825 2.3C7.05833 2.1 6.28333 2 5.5 2C4.9 2 4.304 2.05833 3.712 2.175C3.12 2.29167 2.54933 2.46667 2 2.7V12.6C2.58333 12.4 3.16267 12.25 3.738 12.15C4.31333 12.05 4.90067 12 5.5 12ZM12 13.05C12.7333 12.7 13.471 12.4377 14.213 12.263C14.955 12.0883 15.7173 12.0007 16.5 12C17.1 12 17.6877 12.05 18.263 12.15C18.8383 12.25 19.4173 12.4 20 12.6V2.7C19.45 2.46667 18.879 2.29167 18.287 2.175C17.695 2.05833 17.0993 2 16.5 2C15.7167 2 14.9417 2.1 14.175 2.3C13.4083 2.5 12.6833 2.8 12 3.2V13.05ZM11 16C10.2 15.3667 9.33333 14.875 8.4 14.525C7.46667 14.175 6.5 14 5.5 14C4.8 14 4.11267 14.0917 3.438 14.275C2.76333 14.4583 2.11733 14.7167 1.5 15.05C1.15 15.2333 0.812667 15.225 0.488 15.025C0.163333 14.825 0.000666667 14.5333 0 14.15V2.1C0 1.91667 0.046 1.74167 0.138 1.575C0.23 1.40833 0.367333 1.28333 0.55 1.2C1.31667 0.8 2.11667 0.5 2.95 0.3C3.78333 0.1 4.63333 0 5.5 0C6.46667 0 7.41267 0.125 8.338 0.375C9.26333 0.625 10.1507 1 11 1.5C11.85 1 12.7377 0.625 13.663 0.375C14.5883 0.125 15.534 0 16.5 0C17.3667 0 18.2167 0.1 19.05 0.3C19.8833 0.5 20.6833 0.8 21.45 1.2C21.6333 1.28333 21.771 1.40833 21.863 1.575C21.955 1.74167 22.0007 1.91667 22 2.1V14.15C22 14.5333 21.8377 14.825 21.513 15.025C21.1883 15.225 20.8507 15.2333 20.5 15.05C19.8833 14.7167 19.2377 14.4583 18.563 14.275C17.8883 14.0917 17.2007 14 16.5 14C15.5 14 14.5333 14.175 13.6 14.525C12.6667 14.875 11.8 15.3667 11 16Z" fill="#FFD12C"/>
                    <title>Add Recipe</title>
                </svg>

            </div>
            

            
            <div class="icons">
                <!--
                    *
                    * WIKI
                    * Directly links to the wiki for this particular item
                    * Ex: wiki.guildwars2.com/wiki/Shard_of_Endeavor
                -->

                <svg @click="wiki(entry.name)" class="icon clickable" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 0C11.2311 0 8.52431 0.821086 6.22202 2.35943C3.91973 3.89777 2.12532 6.08427 1.06569 8.64243C0.00606596 11.2006 -0.271181 14.0155 0.269012 16.7313C0.809205 19.447 2.14258 21.9416 4.10051 23.8995C6.05845 25.8574 8.55301 27.1908 11.2687 27.731C13.9845 28.2712 16.7994 27.9939 19.3576 26.9343C21.9157 25.8747 24.1022 24.0803 25.6406 21.778C27.1789 19.4757 28 16.7689 28 14C28 10.287 26.525 6.72601 23.8995 4.1005C21.274 1.475 17.713 0 14 0ZM26 13H20C19.8833 9.31709 18.9291 5.70915 17.21 2.45C19.5786 3.0979 21.6914 4.45684 23.2632 6.34342C24.8351 8.23 25.7903 10.5534 26 13ZM14 26C13.7769 26.015 13.5531 26.015 13.33 26C11.2583 22.6962 10.1085 18.8981 10 15H18C17.9005 18.8953 16.7612 22.6932 14.7 26C14.467 26.0164 14.2331 26.0164 14 26ZM10 13C10.0995 9.10468 11.2388 5.30682 13.3 2C13.7453 1.94997 14.1947 1.94997 14.64 2C16.7223 5.3008 17.8825 9.09906 18 13H10ZM10.76 2.45C9.0513 5.71164 8.10746 9.31945 8.00001 13H2.00001C2.20971 10.5534 3.16495 8.23 4.7368 6.34342C6.30865 4.45684 8.42144 3.0979 10.79 2.45H10.76ZM2.05001 15H8.05001C8.15437 18.6798 9.09478 22.2875 10.8 25.55C8.43887 24.8951 6.33478 23.5332 4.77056 21.6472C3.20634 19.7612 2.25695 17.4415 2.05001 15ZM17.21 25.55C18.9291 22.2908 19.8833 18.6829 20 15H26C25.7903 17.4466 24.8351 19.77 23.2632 21.6566C21.6914 23.5432 19.5786 24.9021 17.21 25.55Z" fill="#FFD12C"/>
                    <title>Wiki</title>
                </svg>
                <!--
                    *
                    * POP ENTRY
                    *
                -->
                <svg 
                    class="icon clickable" 
                    @click="$emit('popEntry', entryIndex)"
                    width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M13 1L1 13M1 1L13 13" stroke="#FFD12C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <title>Remove Item</title>
                </svg>
            </div>
        </div>
        
    </div>

    <SearchItem
        v-if="entry.primarySearchItemToggle"
        @handle-item-search="(searchQuery) => handleIngredientSearch(entry, searchQuery)"
    />

    <SearchRecipe
        v-if="entry.primarySearchRecipeToggle"
        @handle-recipe-request="(searchQuery, quantity) => handleRecipeSearch(entry, searchQuery, quantity)"
    />

    <AddCustomEntry
        v-if="entry.primaryAddCustomEntry"
        @add-custom-entry="(quantity, customEntry) => addCustomEntry(entry, quantity, customEntry)"
    />

    <!--
        *
        * INGREDIENTS
        *
    -->
    <div v-for="(item, itemIndex) in entry.ingredients">
        <div
            v-if="item.expand"
            class="item-container"
        >
            <div class="item">
                <div class="checkbox">
                    <input 
                        type="checkbox" 
                        v-model="item.checked"
                        @change="
                            checkSubBoxes(item, item.checked);
                            $emit('handleUnsavedChanges', true);
                        "
                    >
                    
                    <label :for="item.name">
                        <img v-if="item.icon" :src="item.icon" :alt="item.name" :title="item.name">
                        <p :class="checkFade(item.checked)">{{ item.count }} {{ item.name }}</p>
                    </label>
                </div>

                <div class="icon-container">
                    <div class="icons">
                        <svg 
                            v-if="item.ingredients"
                            class="icon expand" 
                            :class="rotate(item.ingredients[0].expand)"
                            @click="expandSubIngredients(item)"
                            width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M8.81372 0.397634C8.6944 0.280464 8.5326 0.214642 8.36389 0.214642C8.19519 0.214642 8.03339 0.280464 7.91407 0.397634L4.76468 3.49138L1.61529 0.397634C1.49529 0.283785 1.33457 0.220788 1.16775 0.222212C1.00093 0.223636 0.841356 0.289367 0.723392 0.405247C0.605428 0.521127 0.538516 0.677885 0.537066 0.841758C0.535617 1.00563 0.599746 1.16351 0.715642 1.28138L4.31486 4.81701C4.43417 4.93418 4.59597 5 4.76468 5C4.93339 5 5.09519 4.93418 5.2145 4.81701L8.81372 1.28138C8.93299 1.16418 9 1.00524 9 0.839509C9 0.673781 8.93299 0.514838 8.81372 0.397634Z" fill="#FFD12C"/>
                            <title>Expand</title>
                        </svg>

                        <!--
                            *
                            * ADD SUB-CUSTOM INGREDIENT
                            * Only show for custom entries, not recipe entries
                        -->

                        <svg 
                            class="icon clickable" 
                            :class="activeButton(item.addCustomEntry)"
                            @click="item.addCustomEntry = !item.addCustomEntry"
                            width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.8436 1.42344C13.5373 0.865625 12.8061 0.5 11.9998 0.5C11.1936 0.5 10.4623 0.865625 10.1561 1.42344L2.65608 14.9234L0.156078 19.4234C-0.268922 20.1875 0.212329 21.0641 1.23108 21.3828C2.24983 21.7016 3.41858 21.3406 3.84358 20.5766L5.83108 17H18.1623L20.1498 20.5766C20.5748 21.3406 21.7436 21.7016 22.7623 21.3828C23.7811 21.0641 24.2623 20.1875 23.8373 19.4234L21.3373 14.9234L13.8373 1.42344H13.8436ZM16.4998 14H7.49983L11.9998 5.9L16.4998 14Z" fill="#FFD12C"/>
                            <title>Add Custom Entry</title>
                        </svg>


                        <svg 
                            @click="item.searchItemToggle = !item.searchItemToggle"
                            class="icon clickable" 
                            :class="activeButton(item.searchItemToggle)"
                            width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M18.2497 3.64508e-09H12.2497C12.1348 -1.13191e-05 12.0215 0.0263566 11.9185 0.0770702C11.8154 0.127784 11.7254 0.201488 11.6553 0.2925L5.65532 8.09344L4.7497 7.18969C4.61039 7.05022 4.44495 6.93958 4.26286 6.8641C4.08076 6.78861 3.88557 6.74976 3.68845 6.74976C3.49132 6.74976 3.29613 6.78861 3.11404 6.8641C2.93194 6.93958 2.76651 7.05022 2.6272 7.18969L1.43751 8.38031C1.29818 8.5196 1.18766 8.68498 1.11226 8.86699C1.03686 9.049 0.998047 9.24408 0.998047 9.44109C0.998047 9.63811 1.03686 9.83319 1.11226 10.0152C1.18766 10.1972 1.29818 10.3626 1.43751 10.5019L3.31251 12.3769L0.687508 15.0019C0.548184 15.1412 0.437664 15.3065 0.36226 15.4886C0.286857 15.6706 0.248047 15.8656 0.248047 16.0627C0.248047 16.2597 0.286857 16.4548 0.36226 16.6368C0.437664 16.8188 0.548184 16.9841 0.687508 17.1234L1.8772 18.3122C2.15847 18.5933 2.53985 18.7512 2.93751 18.7512C3.33516 18.7512 3.71654 18.5933 3.99782 18.3122L6.62282 15.6872L8.49782 17.5622C8.63713 17.7017 8.80256 17.8123 8.98466 17.8878C9.16676 17.9633 9.36195 18.0021 9.55907 18.0021C9.75619 18.0021 9.95138 17.9633 10.1335 17.8878C10.3156 17.8123 10.481 17.7017 10.6203 17.5622L11.81 16.3716C11.9493 16.2323 12.0599 16.0669 12.1353 15.8849C12.2107 15.7029 12.2495 15.5078 12.2495 15.3108C12.2495 15.1138 12.2107 14.9187 12.1353 14.7367C12.0599 14.5547 11.9493 14.3893 11.81 14.25L10.9063 13.3463L18.7072 7.34625C18.7985 7.276 18.8723 7.18567 18.923 7.08227C18.9738 6.97887 19 6.86517 18.9997 6.75V0.75C18.9997 0.551088 18.9207 0.360322 18.78 0.21967C18.6394 0.0790178 18.4486 3.64508e-09 18.2497 3.64508e-09ZM2.93938 17.25L1.7497 16.0613L4.3747 13.4363L5.56345 14.625L2.93938 17.25ZM9.55907 16.5L2.4997 9.44156L3.69032 8.25L10.7497 15.3103L9.55907 16.5ZM17.4997 6.38062L9.83657 12.2756L8.81095 11.25L13.5303 6.53063C13.6709 6.38989 13.7499 6.19907 13.7498 6.00014C13.7497 5.8012 13.6706 5.61045 13.5299 5.46984C13.3891 5.32924 13.1983 5.2503 12.9994 5.25038C12.8004 5.25047 12.6097 5.32958 12.4691 5.47031L7.7497 10.1887L6.72501 9.16313L12.6191 1.5H17.4997V6.38062Z" fill="#FFD12C"/>
                            <title>Add Item</title>
                        </svg>
                        <svg 
                            @click="item.searchRecipeToggle = !item.searchRecipeToggle"
                            class="icon clickable"
                            :class="activeButton(item.searchRecipeToggle)"
                            width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M13 5.9V4.2C13.55 3.96667 14.1127 3.79167 14.688 3.675C15.2633 3.55833 15.8673 3.5 16.5 3.5C16.9333 3.5 17.3583 3.53333 17.775 3.6C18.1917 3.66667 18.6 3.75 19 3.85V5.45C18.6 5.3 18.1957 5.18767 17.787 5.113C17.3783 5.03833 16.9493 5.00067 16.5 5C15.8667 5 15.2583 5.07933 14.675 5.238C14.0917 5.39667 13.5333 5.61733 13 5.9ZM13 11.4V9.7C13.55 9.46667 14.1127 9.29167 14.688 9.175C15.2633 9.05833 15.8673 9 16.5 9C16.9333 9 17.3583 9.03333 17.775 9.1C18.1917 9.16667 18.6 9.25 19 9.35V10.95C18.6 10.8 18.1957 10.6873 17.787 10.612C17.3783 10.5367 16.9493 10.4993 16.5 10.5C15.8667 10.5 15.2583 10.575 14.675 10.725C14.0917 10.875 13.5333 11.1 13 11.4ZM13 8.65V6.95C13.55 6.71667 14.1127 6.54167 14.688 6.425C15.2633 6.30833 15.8673 6.25 16.5 6.25C16.9333 6.25 17.3583 6.28333 17.775 6.35C18.1917 6.41667 18.6 6.5 19 6.6V8.2C18.6 8.05 18.1957 7.93733 17.787 7.862C17.3783 7.78667 16.9493 7.74933 16.5 7.75C15.8667 7.75 15.2583 7.82933 14.675 7.988C14.0917 8.14667 13.5333 8.36733 13 8.65ZM5.5 12C6.28333 12 7.046 12.0877 7.788 12.263C8.53 12.4383 9.26733 12.7007 10 13.05V3.2C9.31667 2.8 8.59167 2.5 7.825 2.3C7.05833 2.1 6.28333 2 5.5 2C4.9 2 4.304 2.05833 3.712 2.175C3.12 2.29167 2.54933 2.46667 2 2.7V12.6C2.58333 12.4 3.16267 12.25 3.738 12.15C4.31333 12.05 4.90067 12 5.5 12ZM12 13.05C12.7333 12.7 13.471 12.4377 14.213 12.263C14.955 12.0883 15.7173 12.0007 16.5 12C17.1 12 17.6877 12.05 18.263 12.15C18.8383 12.25 19.4173 12.4 20 12.6V2.7C19.45 2.46667 18.879 2.29167 18.287 2.175C17.695 2.05833 17.0993 2 16.5 2C15.7167 2 14.9417 2.1 14.175 2.3C13.4083 2.5 12.6833 2.8 12 3.2V13.05ZM11 16C10.2 15.3667 9.33333 14.875 8.4 14.525C7.46667 14.175 6.5 14 5.5 14C4.8 14 4.11267 14.0917 3.438 14.275C2.76333 14.4583 2.11733 14.7167 1.5 15.05C1.15 15.2333 0.812667 15.225 0.488 15.025C0.163333 14.825 0.000666667 14.5333 0 14.15V2.1C0 1.91667 0.046 1.74167 0.138 1.575C0.23 1.40833 0.367333 1.28333 0.55 1.2C1.31667 0.8 2.11667 0.5 2.95 0.3C3.78333 0.1 4.63333 0 5.5 0C6.46667 0 7.41267 0.125 8.338 0.375C9.26333 0.625 10.1507 1 11 1.5C11.85 1 12.7377 0.625 13.663 0.375C14.5883 0.125 15.534 0 16.5 0C17.3667 0 18.2167 0.1 19.05 0.3C19.8833 0.5 20.6833 0.8 21.45 1.2C21.6333 1.28333 21.771 1.40833 21.863 1.575C21.955 1.74167 22.0007 1.91667 22 2.1V14.15C22 14.5333 21.8377 14.825 21.513 15.025C21.1883 15.225 20.8507 15.2333 20.5 15.05C19.8833 14.7167 19.2377 14.4583 18.563 14.275C17.8883 14.0917 17.2007 14 16.5 14C15.5 14 14.5333 14.175 13.6 14.525C12.6667 14.875 11.8 15.3667 11 16Z" fill="#FFD12C"/>
                            <title>Add Recipe</title>
                        </svg>
                    </div>
                    

                    <div class="icons">
                        <!--
                            *
                            * WIKI
                            * Directly links to the wiki for this particular item
                            * Ex: wiki.guildwars2.com/wiki/Shard_of_Endeavor
                        -->

                        <svg @click="wiki(item.name)" class="icon clickable" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 0C11.2311 0 8.52431 0.821086 6.22202 2.35943C3.91973 3.89777 2.12532 6.08427 1.06569 8.64243C0.00606596 11.2006 -0.271181 14.0155 0.269012 16.7313C0.809205 19.447 2.14258 21.9416 4.10051 23.8995C6.05845 25.8574 8.55301 27.1908 11.2687 27.731C13.9845 28.2712 16.7994 27.9939 19.3576 26.9343C21.9157 25.8747 24.1022 24.0803 25.6406 21.778C27.1789 19.4757 28 16.7689 28 14C28 10.287 26.525 6.72601 23.8995 4.1005C21.274 1.475 17.713 0 14 0ZM26 13H20C19.8833 9.31709 18.9291 5.70915 17.21 2.45C19.5786 3.0979 21.6914 4.45684 23.2632 6.34342C24.8351 8.23 25.7903 10.5534 26 13ZM14 26C13.7769 26.015 13.5531 26.015 13.33 26C11.2583 22.6962 10.1085 18.8981 10 15H18C17.9005 18.8953 16.7612 22.6932 14.7 26C14.467 26.0164 14.2331 26.0164 14 26ZM10 13C10.0995 9.10468 11.2388 5.30682 13.3 2C13.7453 1.94997 14.1947 1.94997 14.64 2C16.7223 5.3008 17.8825 9.09906 18 13H10ZM10.76 2.45C9.0513 5.71164 8.10746 9.31945 8.00001 13H2.00001C2.20971 10.5534 3.16495 8.23 4.7368 6.34342C6.30865 4.45684 8.42144 3.0979 10.79 2.45H10.76ZM2.05001 15H8.05001C8.15437 18.6798 9.09478 22.2875 10.8 25.55C8.43887 24.8951 6.33478 23.5332 4.77056 21.6472C3.20634 19.7612 2.25695 17.4415 2.05001 15ZM17.21 25.55C18.9291 22.2908 19.8833 18.6829 20 15H26C25.7903 17.4466 24.8351 19.77 23.2632 21.6566C21.6914 23.5432 19.5786 24.9021 17.21 25.55Z" fill="#FFD12C"/>
                            <title>Wiki</title>
                        </svg>


                        
                        <!--
                            *
                            * POP ITEM
                            *
                        -->
                        <svg 
                            class="icon clickable" 
                            @click="popItem(itemIndex)"
                            width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M13 1L1 13M1 1L13 13" stroke="#FFD12C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <title>Remove Item</title>
                        </svg>
                    </div>
                </div>
                
            </div>

            <SearchItem
                v-if="item.searchItemToggle"
                @handle-item-search="(searchQuery) => handleIngredientSearch(item, searchQuery)"
            />

            <SearchRecipe
                v-if="item.searchRecipeToggle"
                @handle-recipe-request="(searchQuery, quantity) => handleRecipeSearch(item, searchQuery, quantity)"
            />

            <AddCustomEntry
                v-if="item.addCustomEntry"
                @add-custom-entry="(quantity, entry) => addCustomEntry(item, quantity, entry)"
            />

            <!--
                * IF the item contains more 'ingredients', start recursion
            -->
            <List
                v-if="item.ingredients"
                :entry="item"
                :entryIndex="entryIndex"
                :recursion-level="recursionLevel + 1"
                @handle-unsaved-changes="handleUnsavedChanges"
            />
        </div>
    </div>
    

    <Loading v-if="currentlyFetching" :width="200" :height="200"/>
</template>

<script setup>
import { computed, ref } from 'vue'
import { wiki } from '@/js/vue/composables/BasicFunctions'

import SearchRecipe from '@/js/vue/components/general/SearchRecipe.vue'
import SearchItem from '@/js/vue/components/general/SearchItem.vue'
import AddCustomEntry from '@/js/vue/components/general/AddCustomEntry.vue'
import Loading from '@/js/vue/components/general/Loading.vue'
import Expand from '@/imgs/svgs/expand.svg'

const props = defineProps({
    quantity: Number,
    entry: Object,
    entryIndex: Number,
    recursionLevel: {
        type: Number,
        default: 0,
    },
})
const emit = defineEmits(['popEntry', 'addCustomIngredient', 'handleUnsavedChanges']);

const ingredientsToggle = ref(props.recursionLevel == 0 ? false : true);
const currentlyFetching = ref(false);

// Emit to main parent
// Create this since <List/> recursively gets created and needs a callback chain
const handleUnsavedChanges = (unsaved) => {
    emit('handleUnsavedChanges', unsaved);
}

const handleRecipeSearch = async (item, searchQuery, quantity) => {
    currentlyFetching.value = true; 
    
    const response = await fetch(`../api/recipes/${searchQuery.id}/${quantity}`);
    const responseData = await response.json();

    if (responseData){
        if (!item.ingredients){
            item.ingredients = [];
            expandSubIngredients(item);
        }
        else if (!item.ingredients[0].expand){
            expandSubIngredients(item);
        }
        
        responseData.forEach(ingredient => {
            
            item.ingredients.push({
                count: quantity,
                name: ingredient.name,
                icon: ingredient.icon,
                ingredients: ingredient.ingredients,
                expand: true,
            });
        })

        handleUnsavedChanges(true); 
        currentlyFetching.value = false;
    }
    
    
    
}

const handleIngredientSearch = (item, searchQuery) => {
    currentlyFetching.value = true; 

    if (!item.ingredients){
        item.ingredients = [];
        expandSubIngredients(item);
    }
    else if (!item.ingredients[0].expand){
        expandSubIngredients(item);
    }
    item.ingredients.push({
        count: searchQuery.count,
        name: searchQuery.name,
        icon: searchQuery.icon,
        expand: true,
    });

    handleUnsavedChanges(true); 
    currentlyFetching.value = false; 

}

const addCustomEntry = (item, count, entry) => {
    currentlyFetching.value = true; 

    if (!item.ingredients){
        item.ingredients = [];
        expandSubIngredients(item);
    } 
    else if (!item.ingredients[0].expand){
        expandSubIngredients(item);
    }

    item.ingredients.push({
        count: count != 0 ? count : null,
        name: entry,
        expand: true,
    });

    handleUnsavedChanges(true); 
    currentlyFetching.value = false;
}

const popItem = (itemIndex) => {
    console.log('delete: ', props.entry.ingredients);
    props.entry.ingredients.splice(itemIndex, 1);

    // If there is no more ingredients, remove .ingredients entirely
    if (props.entry.ingredients.length == 0){
        delete props.entry.ingredients; 
    }

    handleUnsavedChanges(true); 
}

const checkSubBoxes = (data, isChecked) => {
    //console.log('checked data: ', data, isChecked);
    data.checked = isChecked;
    if (data.ingredients){
        data.ingredients.forEach(subItem => {
            //console.log('subItems: ', subItem);
            subItem.checked = isChecked;
            checkSubBoxes(subItem, isChecked);
        });
        //console.log('data ingredients: ', data.ingredients);
    }
}

const expandSubIngredients = (data) => {
    if (data.ingredients){
        data.ingredients.forEach(subItem => {
            if (!subItem.hasOwnProperty('expand')){
                subItem.expand = true; 
            } else {
                subItem.expand = !subItem.expand;
            }
            expandSubIngredients(subItem);
        })
    }
    

}


/*
    *
    * DYNAMIC CLASSES
    * 
*/
const rotate = (itemExpandToggle) => {
    if (itemExpandToggle){
        return 'rotate active-checklist'
    } else {
        return ''
    }
}
// Turns button red when active
const activeButton = (toggle) => {
    if (toggle){
        return 'active-checklist'
    } else {
        return ''
    }
}


const checkFade = (checkStatus) => {
    return checkStatus === true ? 'strikethrough' : '';
}

</script>

<style scoped>
.checkbox label {
    cursor: unset;
}

.item-container{
    padding: 0px 0px 0px 30px;
    border-left: var(--border-general);
}
.item-container:hover{
    border-left: var(--border-left-hover);
}
.primary-item{
    display: flex;
    align-items: center;
    gap: var(--gap-general);
    padding-block: var(--gap-general);
    transition: var(--transition-all-03s-ease);
}
.item{
    display: flex;
    align-items: center;
    gap: 10px;
    padding-block: var(--gap-general);
    transition: var(--transition-all-03s-ease);
}
.primary-item img,
.item img{
    width: var(--img-material-w);
}
.primary-item:hover,
.item:hover{
    background-color: var(--color-bkg-fade);
}

/* By default, the expand svg is facing down. This should face is up then use the dynamic class 'rotate' to 180 it */
.expand{
    transform: rotate(180deg);
}
.rotate {
    transform: rotate(0deg);
}

</style>