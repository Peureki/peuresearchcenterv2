<template>
    <div class="card-grid">
        <div class="card-container"
            :style="{border: dailyBorderColor(fishingHole)}"
            v-for="(fishingHole, index) in fishingHoles" :key="index"
        >
            <p class="rank">{{ index + 1 }}</p>
            <div class="card">
                <img class="card-main-icon" :src="fishingHole.mostValuedIcon" :alt="fishingHole.mostValuedItem" :title="fishingHole.mostValuedItem">
                <div class="card-details">
                    <!--
                        *
                        * TITLE AND ESTIMATES
                        *
                    -->
                    <span class="card-title-and-value">
                        <span class="title-container">
                            <p class="title" :class="changeTimeBackground(fishingHole.time)">{{ fishingHole.name }}</p>
                            <!--
                                *
                                * SVG SIGNAL
                                *
                            -->
                            <svg 
                                class="signal" 
                                :class="matchTyrianTime(fishingHole.time, fishingHole.region)"
                                width="30" height="30" xmlns="http://www.w3.org/2000/svg"
                            >
                                <circle class="fill-circle" cx="15" cy="15" r="5" stroke="black" stroke-width="1" />
                                <circle class="expand-circle" cx="15" cy="15" r="15"  fill="transparent" stroke-width="1"/>
                                <title>{{ matchTyrianTime(fishingHole.time, fishingHole.region) }}</title>
                            </svg>
                            <!--
                                *
                                * DAILY FISH MESSAGE
                                *
                            -->
                            <p v-if="matchDailyCatch(fishingHole)" class="small-subtitle">{{ matchDailyCatch(fishingHole).daily }}</p>
                        </span>
                        
                        <span class="gold-label-container benchmark-value">
                            <span 
                                class="gold-label"
                                v-for="gold in formatValue(fishingHole.estimateValue)"
                            >
                                {{ gold.value }}<img :src="gold.src" :alt="gold.alt" :title="gold.title">
                            </span>
                        </span>
                    </span>
                    <!--
                        *
                        * MAP AND card-info-container
                        *
                    -->
                    <span class="card-map-and-info">
                        <p class="map-and-info">{{ fishingHole.map}}, {{ fishingHole.region }}</p>

                        <!--
                            *
                            * card-info-container
                            *
                        -->
                        <span class="card-info-container">
                            <img class="bait" :src="fishingHole.baitIcon" :alt="fishingHole.bait" :title="fishingHole.bait">
                            
                            <span class="fishing-power">
                                <img class="card-currency" :src="GreenHook" alt="Fishing Power" title="Fishing Power">
                                <p>{{ fishingHole.fishingPower }}</p>
                            </span>

                            <svg 
                                class="sun"
                                v-if="fishingHole.time == 'Daytime'"
                                width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M11.7188 3.90625V1.5625C11.7188 1.3553 11.8011 1.15659 11.9476 1.01007C12.0941 0.86356 12.2928 0.78125 12.5 0.78125C12.7072 0.78125 12.9059 0.86356 13.0524 1.01007C13.1989 1.15659 13.2812 1.3553 13.2812 1.5625V3.90625C13.2812 4.11345 13.1989 4.31216 13.0524 4.45868C12.9059 4.60519 12.7072 4.6875 12.5 4.6875C12.2928 4.6875 12.0941 4.60519 11.9476 4.45868C11.8011 4.31216 11.7188 4.11345 11.7188 3.90625ZM12.5 6.25C11.2639 6.25 10.0555 6.61656 9.02769 7.30331C7.99988 7.99007 7.1988 8.96619 6.72575 10.1082C6.25271 11.2503 6.12893 12.5069 6.37009 13.7193C6.61125 14.9317 7.2065 16.0453 8.08058 16.9194C8.95466 17.7935 10.0683 18.3888 11.2807 18.6299C12.4931 18.8711 13.7497 18.7473 14.8918 18.2742C16.0338 17.8012 17.0099 17.0001 17.6967 15.9723C18.3834 14.9445 18.75 13.7361 18.75 12.5C18.7482 10.843 18.0891 9.25429 16.9174 8.08258C15.7457 6.91087 14.157 6.25181 12.5 6.25ZM5.69727 6.80273C5.84386 6.94933 6.04268 7.03168 6.25 7.03168C6.45732 7.03168 6.65614 6.94933 6.80273 6.80273C6.94933 6.65614 7.03168 6.45732 7.03168 6.25C7.03168 6.04268 6.94933 5.84386 6.80273 5.69727L5.24023 4.13477C5.09364 3.98817 4.89482 3.90582 4.6875 3.90582C4.48018 3.90582 4.28136 3.98817 4.13477 4.13477C3.98817 4.28136 3.90582 4.48018 3.90582 4.6875C3.90582 4.89482 3.98817 5.09364 4.13477 5.24023L5.69727 6.80273ZM5.69727 18.1973L4.13477 19.7598C3.98817 19.9064 3.90582 20.1052 3.90582 20.3125C3.90582 20.5198 3.98817 20.7186 4.13477 20.8652C4.28136 21.0118 4.48018 21.0942 4.6875 21.0942C4.89482 21.0942 5.09364 21.0118 5.24023 20.8652L6.80273 19.3027C6.87532 19.2301 6.9329 19.144 6.97218 19.0491C7.01147 18.9543 7.03168 18.8527 7.03168 18.75C7.03168 18.6473 7.01147 18.5457 6.97218 18.4509C6.9329 18.356 6.87532 18.2699 6.80273 18.1973C6.73015 18.1247 6.64398 18.0671 6.54914 18.0278C6.4543 17.9885 6.35265 17.9683 6.25 17.9683C6.14735 17.9683 6.0457 17.9885 5.95086 18.0278C5.85602 18.0671 5.76985 18.1247 5.69727 18.1973ZM18.75 7.03125C18.8526 7.03133 18.9543 7.01119 19.0491 6.97198C19.1439 6.93277 19.2301 6.87526 19.3027 6.80273L20.8652 5.24023C21.0118 5.09364 21.0942 4.89482 21.0942 4.6875C21.0942 4.48018 21.0118 4.28136 20.8652 4.13477C20.7186 3.98817 20.5198 3.90582 20.3125 3.90582C20.1052 3.90582 19.9064 3.98817 19.7598 4.13477L18.1973 5.69727C18.0879 5.80653 18.0134 5.94579 17.9832 6.09742C17.953 6.24905 17.9685 6.40622 18.0276 6.54906C18.0868 6.69189 18.187 6.81394 18.3156 6.89978C18.4442 6.98562 18.5954 7.03137 18.75 7.03125ZM19.3027 18.1973C19.1561 18.0507 18.9573 17.9683 18.75 17.9683C18.5427 17.9683 18.3439 18.0507 18.1973 18.1973C18.0507 18.3439 17.9683 18.5427 17.9683 18.75C17.9683 18.9573 18.0507 19.1561 18.1973 19.3027L19.7598 20.8652C19.8324 20.9378 19.9185 20.9954 20.0134 21.0347C20.1082 21.074 20.2098 21.0942 20.3125 21.0942C20.4152 21.0942 20.5168 21.074 20.6116 21.0347C20.7065 20.9954 20.7926 20.9378 20.8652 20.8652C20.9378 20.7926 20.9954 20.7065 21.0347 20.6116C21.074 20.5168 21.0942 20.4152 21.0942 20.3125C21.0942 20.2098 21.074 20.1082 21.0347 20.0134C20.9954 19.9185 20.9378 19.8324 20.8652 19.7598L19.3027 18.1973ZM4.6875 12.5C4.6875 12.2928 4.60519 12.0941 4.45868 11.9476C4.31216 11.8011 4.11345 11.7188 3.90625 11.7188H1.5625C1.3553 11.7188 1.15659 11.8011 1.01007 11.9476C0.86356 12.0941 0.78125 12.2928 0.78125 12.5C0.78125 12.7072 0.86356 12.9059 1.01007 13.0524C1.15659 13.1989 1.3553 13.2812 1.5625 13.2812H3.90625C4.11345 13.2812 4.31216 13.1989 4.45868 13.0524C4.60519 12.9059 4.6875 12.7072 4.6875 12.5ZM12.5 20.3125C12.2928 20.3125 12.0941 20.3948 11.9476 20.5413C11.8011 20.6878 11.7188 20.8865 11.7188 21.0938V23.4375C11.7188 23.6447 11.8011 23.8434 11.9476 23.9899C12.0941 24.1364 12.2928 24.2188 12.5 24.2188C12.7072 24.2188 12.9059 24.1364 13.0524 23.9899C13.1989 23.8434 13.2812 23.6447 13.2812 23.4375V21.0938C13.2812 20.8865 13.1989 20.6878 13.0524 20.5413C12.9059 20.3948 12.7072 20.3125 12.5 20.3125ZM23.4375 11.7188H21.0938C20.8865 11.7188 20.6878 11.8011 20.5413 11.9476C20.3948 12.0941 20.3125 12.2928 20.3125 12.5C20.3125 12.7072 20.3948 12.9059 20.5413 13.0524C20.6878 13.1989 20.8865 13.2812 21.0938 13.2812H23.4375C23.6447 13.2812 23.8434 13.1989 23.9899 13.0524C24.1364 12.9059 24.2188 12.7072 24.2188 12.5C24.2188 12.2928 24.1364 12.0941 23.9899 11.9476C23.8434 11.8011 23.6447 11.7188 23.4375 11.7188Z" fill="var(--color-text)"/>
                            </svg>

                            <svg 
                                class="moon"
                                v-else
                                width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M5.67754 4.45195C5.67754 3.16289 5.86699 1.86016 6.35059 0.75C3.13535 2.14961 0.96582 5.4332 0.96582 9.16328C0.96582 14.1816 5.03418 18.25 10.0525 18.25C13.7826 18.25 17.0662 16.0805 18.4658 12.8652C17.3557 13.3488 16.0518 13.5383 14.7639 13.5383C9.74551 13.5383 5.67754 9.47031 5.67754 4.45195Z" fill="var(--color-text)"/>
                            </svg>

                            <svg 
                                class="arrow"
                                @click="expand[index] = !expand[index]"
                                :class="activeArrow(expand[index])"
                                width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M0.32246 8.33324V6.66657L10.3225 6.66657L5.73913 2.08324L6.92246 0.899902L13.5225 7.4999L6.92246 14.0999L5.73913 12.9166L10.3225 8.33324H0.32246Z" fill="var(--color-text)"/>
                            </svg>
                        </span>
                        
                    </span>
                </div>
            </div>

            <div 
                v-if="expand[index]"
                class="details-container"
            >
                <MobileDetailsTable
                    :drop-rates="dropRates[index]"
                />
                <div class="details">
                    <PieChart
                        :drop-rates="dropRates[index]"
                    />

                    <FishProofs
                        :fishing-hole="fishingHole"
                    />

                    <!--
                        * AMNYTAS, ASTRAL FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Amnytas'">
                        <p>This will not complete a full hours worth of fishing in the same way that you can continously go from pool to pool non-stop. This has a high ascended rate of fish so I wanted to put this benchmark to see where it would be. If you follow all the directions below, you will get a decent ~25 minute run, but then there will be a pause.</p>
                    </Disclaimer>
                    <AmnytasAstralFish v-if="fishingHole.map == 'Amnytas'"/>

                    <!-- 
                        * BLOODTIDE COAST, COASTAL FISH
                    -->
                    <BloodtideCoast v-if="fishingHole.map == 'Bloodtide Coast'"/>

                    <!--
                        * CALEDON FOREST, SALTWATER FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Caledon Forest'">
                        <p>This is probably my least favorite route ever. There are multiple mobs that will pull you off your skiff and put you in combat and may make you lose your stacks.</p>
                    </Disclaimer>
                    <CaledonForest v-if="fishingHole.map == 'Caledon Forest'"/>

                    <!--
                        * CRYSTAL OASIS, DESERT FISH
                    -->
                    <CrystalOasis v-if="fishingHole.map == 'Crystal Oasis'"/>

                    <!--
                        * DRACONIS MONS, VOLCANIC FISH
                    -->
                    <DraconisMons v-if="fishingHole.map == 'Draconis Mons'"/>

                    <!--
                        * DOMAIN OF ISTAN, OFFSHORE FISH
                    -->
                    <DomainOfIstan v-if="fishingHole.map == 'Domain of Istan'"/>

                    <!--
                        * DOMAIN OF KOURNA, DESERT FISH
                    -->
                    <DomainOfKourna v-if="fishingHole.map == 'Domain of Kourna'"/>

                    <!--
                        * DRAGON'S END, CAVERN FISH
                    -->
                    <DragonsEndCavernFish
                        v-if="
                            fishingHole.name == 'Cavern Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Dragon\'s End'" 
                    />

                    <!--
                        * DRAGON'S END, QUARRY FISH
                    -->
                    <Disclaimer
                        v-if="
                            fishingHole.name == 'Quarry Fish' 
                            && fishingHole.time == 'Nighttime' 
                            && fishingHole.map == 'Dragon\'s End'" 
                    >
                        <p>There are so many mobs that may attack you in this route that it's not worth farming.</p>
                    </Disclaimer>
                    <DragonsEndQuarryFish
                        v-if="
                            fishingHole.name == 'Quarry Fish' 
                            && fishingHole.time == 'Nighttime' 
                            && fishingHole.map == 'Dragon\'s End'" 
                    />

                    <!--
                        * DRIZZLEWOOD COAST, LAKE FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Drizzlewood Coast'" type="caution">
                        <p>This is a very unique farm where you can push over 1000 Fishing Power. 925 is from the normal maxing of getting Fishing Power while the additional 92 comes from <a href="https://wiki.guildwars2.com/wiki/Raise_Morale" target="_blank">Raise Morale</a> from the Quartermaster. The south camps need to be completed in order to achieve the maximum morale boost. From my experience, lots of Drizzlewood maps are left abondoned with the south portion completed and north not progressing, which is the perfect opportunity to do this farm.</p>
                    </Disclaimer>
                    <DrizzlewoodCoast
                        v-if="
                            fishingHole.name == 'Lake Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Drizzlewood Coast'" 
                    />

                    <!--
                        * ECHOVALD WILDS, LAKE FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Echovald Wilds'">
                        <p>There is a chance that Qinkai Waypoint may be locked. This happens if the event chain from Jade Gate Waypoint (will have a tangerine symbol if not started) is progressing. The waypoint can be unlocked by completing the event when it reaches Qinkai.</p>
                    </Disclaimer>
                    <EchovaldLakeFish v-if="fishingHole.map == 'Echovald Wilds'"/>

                    <!--
                        * ELON RIVERLANDS, DESERT FISH
                    -->
                    <Disclaimer
                        v-if="
                            fishingHole.name == 'Desert Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Elon Riverlands'" 
                        message="There are many mobs on the south portion of this farm. You can avoid them by fishing at the highest point of your skiff (usually on the tail end)."
                        type="caution"
                    />
                    <ElonRiverlands
                        v-if="
                            fishingHole.name == 'Desert Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Elon Riverlands'" 
                    />

                    <!-- 
                        * FROSTGORGE SOUND, BOREAL FISH 
                    -->
                    <FrostgorgeSound v-if="fishingHole.map == 'Frostgorge Sound'"/>

                    <!--
                        * GENDARREN FIELDS, RIVER FISH
                    -->
                    <GendarrenFieldsRiverFish v-if="fishingHole.map == 'Gendarran Fields'"/>

                    <!--
                        * HOMESTEADS, FRESHWATER FISH
                    -->
                    <Homestead v-if="fishingHole.map == 'Homestead'"/>

                    <!--
                        * INNER NAYOS
                    -->
                    <Disclaimer 
                        v-if="fishingHole.map == 'Inner Nayos'" 
                        type="caution"
                    >
                        <p>While this benchmark is based on Mackerels for the sake of getting the best possible chances, this farm is totally acceptable of using ANY other bait with 875 or 925 Fishing Power.</p>
                    </Disclaimer>
                    <InnerNayosDreamFish v-if="fishingHole.name == 'Dream Fish'"/>
                    <InnerNayosNayosianFish v-if="fishingHole.name == 'Nayosian Fish'"/>
                    

                    <!--
                        * LAKE FISH, DRIZZLEWOOD 
                    -->
                    <Disclaimer 
                        v-if="
                            fishingHole.name == 'Lake Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Drizzlewood Coast'" 
                        type="caution"
                    >
                        <p>This is a very unique farm that can hit over 1000 fishing power. 925 is obtained by the regular maxing method and the rest is obtained when all of the camps on the south side are cleared. While this is situational, lots of empty maps clear south's meta, but do not attempt north without a squad. You can obtain <a href="https://wiki.guildwars2.com/wiki/Raise_Morale" target="_blank">Raise Morale</a> for 30 minutes by exchanging 100 War Supplies</p>
                    </Disclaimer>

                    <!--
                        * LOWLAND SHORE, BRACKISH FISH
                    -->
                    <LowlandShoreBrackishFish
                        v-if="
                            fishingHole.name == 'Lowland Brackish Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Lowland Shore'"
                    />

                    <!--
                        * LOWLAND SHORE, OFFSHORE FISH
                    -->
                    <LowlandShoreOffshoreFish
                        v-if="
                            fishingHole.name == 'Lowland Offshore Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Lowland Shore'"
                    />

                    

                    <!--
                        * LION'S ARCH
                    -->
                    <LionsArch v-if="fishingHole.map == 'Lion\'s Arch'"/>

                    <!--
                        * MOUNT MAELSTROM, SALTWATER FISH
                    -->
                    <MountMaelstrom v-if="fishingHole.map == 'Mount Maelstrom'"/>

                    <!--
                        * NEW KAINENG CITY
                    -->
                    <Disclaimer 
                        v-if="
                            fishingHole.name == 'Channel Fish' 
                            && (fishingHole.time == 'Daytime' || fishingHole.time == 'Nighttime') 
                            && fishingHole.map == 'New Kaineng City'"
                        type="caution"
                    >
                        <p>There may be an annoying event that spawns in the middle of the route there snipers can shoot you. Try your best to get out of sight.</p>
                    </Disclaimer>
                    <NewKainengCityChannelFish
                        v-if="
                            fishingHole.name == 'Channel Fish' 
                            && (fishingHole.time == 'Daytime' || fishingHole.time == 'Nighttime') 
                            && fishingHole.map == 'New Kaineng City'"
                    />
                    <NewKainengCityCoastalFish
                        v-if="
                            fishingHole.name == 'Coastal Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'New Kaineng City'" 
                    />

                    <!--
                        * RATA SUM, SALTWATER FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Rata Sum'" type="caution">
                        <p>Because this is a Saltwater pool, it has a much higher chance to obtain Saltwater Fish to complete the <a href="https://wiki.guildwars2.com/wiki/Saltwater_Fisher" target="_blank">Saltwater Fisher achievement and avid</a>. If you do this farm regularly, it's common to continuously complete the avid. I've had sessions where I completed it in less than an hour from start to finish or within 2 hours. The benchmark currently does not include Avid loot.</p>
                    </Disclaimer>
                    <RataSum v-if="fishingHole.map == 'Rata Sum'"/>

                    <!--
                        * SANDSWEPT ISLES, OFFSHORE FISH
                    -->
                    <SandsweptIslesOffshoreFish
                        v-if="
                            fishingHole.name == 'Offshore Fish' 
                            && fishingHole.time == 'Nighttime' 
                            && fishingHole.map == 'Sandswept Isles'"
                    />

                    <!--
                        * SANDSWEPT ISLES, SHORE FISH
                    -->
                    <SandsweptIslesShoreFish
                        v-if="
                            fishingHole.name == 'Shore Fish' 
                            && fishingHole.time == 'Daytime' 
                            && fishingHole.map == 'Sandswept Isles'" 
                    />

                    <!--
                        * SIREN'S LANDING, SHORE FISH
                    -->
                    <SirensLanding v-if="fishingHole.map == 'Siren\'s Landing'"/>

                    <!--
                        * STRAITS OF DEVESTATION, OFFSHORE FISH
                    -->
                    <StraitsOfDevestationOffshoreFish 
                        v-if="
                            fishingHole.name == 'Offshore Fish' 
                            && (fishingHole.time == 'Nighttime' || fishingHole.time == 'Daytime') 
                            && fishingHole.map == 'Straits of Devestation'" 
                    />

                    <!--
                        * SEITUNG, OFFSHORE FISH
                    -->
                    <Disclaimer 
                        v-if="
                            fishingHole.name == 'Offshore Fish' 
                            && (fishingHole.time == 'Daytime' || fishingHole.time == 'Nighttime')
                            && fishingHole.map == 'Seitung Province'" 
                        type="caution"
                    >
                        <p>Sometimes a Levi will trigger and it will be in parts of the route. Tag if you wish, but careful of the Naga that spawns. If that's the case, I'd tag and leave or keep your skiff afloat and kill. If your skiff disappears though, you will risk losing your stacks.</p>
                    </Disclaimer>
                    <SeitungOffshoreFish
                        v-if="
                            fishingHole.name == 'Offshore Fish' 
                            && (fishingHole.time == 'Daytime' || fishingHole.time == 'Nighttime')
                            && fishingHole.map == 'Seitung Province'" 
                    />

                    <!--
                        * SEITUNG, SHORE FISH
                    -->
                    <SeitungShoreFish
                        v-if="
                            fishingHole.name == 'Shore Fish' 
                            && fishingHole.time == 'Nighttime' 
                            && fishingHole.map == 'Seitung Province'" 
                    />

                    <!--
                        * SKYWATCH, FRESHWATER
                    -->
                    <SkywatchArchipelago v-if="fishingHole.map == 'Skywatch Archipelago'"/>

                    <!--
                        * SNOWDEN DRIFTS, LAKE FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Snowden Drifts'" type="caution">
                        <p>Sometimes there's an event that spawns underwater from the first waypoint. If that's the case, try to position your skiff as far as possible</p>
                    </Disclaimer>
                    <SnowdenDrifts v-if="fishingHole.map == 'Snowden Drifts'" />

                    <!--
                        * SPARKFLY FEN, SALTWATER FISH
                    -->
                    <SparkflyFen v-if="fishingHole.map == 'Sparkfly Fen'"/>

                    <!--
                        * THUNDERHEAD, BOREAL FISH
                    -->
                    <Disclaimer v-if="fishingHole.map == 'Thunderhead Peaks'" type="caution">
                        <p>To avoid the Dredge, park your skiff as far away from the ice as you can.</p>
                    </Disclaimer>
                    <Thunderhead v-if="fishingHole.map == 'Thunderhead Peaks'"/>
                    
                </div>
                
            </div>
        </div> 
    </div>

    

    
</template>

<script setup>
import { ref, computed, watch } from 'vue'

import { formatValue } from '@/js/vue/composables/FormatFunctions.js'
import { activeArrow } from '@/js/vue/composables/BasicFunctions'

import FishTable from '@/js/vue/components/tables/FishTable.vue'
import FishProofs from '@/js/vue/components/general/FishProofs.vue'
import PieChart from '@/js/vue/components/general/PieChart.vue'
import MobileBenchmarkTable from '@/js/vue/components/tables/MobileBenchmarkTable.vue'
import MobileDetailsTable from '@/js/vue/components/tables/MobileDetailsTable.vue'
import Disclaimer from '@/js/vue/components/general/Disclaimer.vue'

import { tyrianCurrentPeriod, canthanCurrentPeriod, isMobile } from '@/js/vue/composables/Global.js'

import GreenHook from '@/imgs/icons/fishes/Green_Hook.png'

// MAP GUIDES
import AmnytasAstralFish from '@/js/vue/components/guides/fishing/AmnytasAstralFish.vue'
import BloodtideCoast from '@/js/vue/components/guides/fishing/BloodtideCoast.vue'
import CaledonForest from '@/js/vue/components/guides/fishing/CaledonForest.vue'
import CrystalOasis from '@/js/vue/components/guides/fishing/CrystalOasis.vue'
import DomainOfIstan from '@/js/vue/components/guides/fishing/DomainOfIstan.vue'
import DomainOfKourna from '@/js/vue/components/guides/fishing/DomainOfKourna.vue'
import DraconisMons from '@/js/vue/components/guides/fishing/DraconisMons.vue'
import DragonsEndCavernFish from '@/js/vue/components/guides/fishing/DragonsEndCavernFish.vue'
import DragonsEndQuarryFish from '@/js/vue/components/guides/fishing/DragonsEndQuarryFish.vue'
import DrizzlewoodCoast from '@/js/vue/components/guides/fishing/DrizzlewoodCoast.vue'
import EchovaldLakeFish from '@/js/vue/components/guides/fishing/EchovaldLakeFish.vue'
import ElonRiverlands from '@/js/vue/components/guides/fishing/ElonRiverlands.vue'
import FrostgorgeSound from '@/js/vue/components/guides/fishing/FrostgorgeSound.vue'
import GendarrenFieldsRiverFish from '@/js/vue/components/guides/fishing/GendarrenFieldsRiverFish.vue'
import Homestead from '@/js/vue/components/guides/fishing/Homestead.vue'
import InnerNayosDreamFish from '@/js/vue/components/guides/fishing/InnerNayosDreamFish.vue'
import InnerNayosNayosianFish from '@/js/vue/components/guides/fishing/InnerNayosNayosianFish.vue'
import LionsArch from '@/js/vue/components/guides/fishing/LionsArch.vue'
import LowlandShoreBrackishFish from '@/js/vue/components/guides/fishing/LowlandShoreBrackishFish.vue'
import LowlandShoreOffshoreFish from '@/js/vue/components/guides/fishing/LowlandShoreOffshoreFish.vue'
import MountMaelstrom from '@/js/vue/components/guides/fishing/MountMaelstrom.vue'
import NewKainengCityChannelFish from '@/js/vue/components/guides/fishing/NewKainengCityChannelFish.vue'
import NewKainengCityCoastalFish from '@/js/vue/components/guides/fishing/NewKainengCityCoastalFish.vue'
import RataSum from '@/js/vue/components/guides/fishing/RataSum.vue'
import SandsweptIslesOffshoreFish from '@/js/vue/components/guides/fishing/SandsweptIslesOffshoreFish.vue'
import SandsweptIslesShoreFish from '@/js/vue/components/guides/fishing/SandsweptIslesShoreFish.vue'
import SirensLanding from '@/js/vue/components/guides/fishing/SirensLanding.vue'
import StraitsOfDevestationOffshoreFish from '@/js/vue/components/guides/fishing/StraitsOfDevestationOffshoreFish.vue'
import SeitungOffshoreFish from '@/js/vue/components/guides/fishing/SeitungOffshoreFish.vue'
import SeitungShoreFish from '@/js/vue/components/guides/fishing/SeitungShoreFish.vue'
import SkywatchArchipelago from '@/js/vue/components/guides/fishing/SkywatchArchipelago.vue'
import SnowdenDrifts from '@/js/vue/components/guides/fishing/SnowdenDrifts.vue'
import SparkflyFen from '@/js/vue/components/guides/fishing/SparkflyFen.vue'
import Thunderhead from '@/js/vue/components/guides/fishing/Thunderhead.vue'


const props = defineProps({
    dailyCatch: Object,
    fishingHoles: Object,
    dropRates: Object,
})

// Individually allow each card to be expanded or not
// By default, have each card not expanded
const expand = ref(props.fishingHoles.map(() => false));
//console.log('drop rates: ', props.dropRates)

const matchDailyCatch = (benchmark) => {
    const checkFishMatch = (fish, benchmark) => {
        // Fish for specifically Brackish & Offshore Fish
        const fish_b_o = ['King Salmon', 'Viperfish', 'Violet Screamer', 'Spectacled Lumper', 'Shaderock Salamander', 'Mohawk Bream'];
        const benchmark_b_o = ['Lowland Brackish Fish', 'Lowland Offshore Fish'];

        // Fish for specifically just Brackish Fish
        const fish_b = ['Cherry Salmon', 'Sockeye'];
        const benchmark_b = ['Lowland Brackish Fish'];

        console.log('fish: ', fish, '| benchmark: ', benchmark.name);

        // Check all possible areas where daily fish is the daily
        if (
            (fish.map === benchmark.region && benchmark.name.includes(fish.fishing_hole)) ||
            (fish_b_o.includes(fish.name) && benchmark_b_o.includes(benchmark.name)) ||
            (fish_b.includes(fish.name) && benchmark_b.includes(benchmark.name)) || 
            // // For special cases such as Maguuma Jungle, Freshwater with Homesteads and SOTO freshwaters
            (fish.map === 'Maguuma Jungle' && fish.fishing_hole == 'Freshwater Fish' && benchmark.name.includes('Freshwater Fish'))
        ){
            if (fish.rarity == 'Masterwork'){
                return {
                    daily: 'Daily Flawless Catch',
                    color: 'var(--color-rarity-masterwork)'
                }
            }
            // Sometimes the daily fish for Janthir are exotic
            if (fish.rarity == 'Rare' || fish.rarity == 'Exotic'){
                return {
                    daily: 'Daily Ambergris Catch',
                    color: 'var(--color-rarity-rare)'
                }
            }
        } 
        else {
            return false; 
        }
    };

    const { arborstone, janthir } = props.dailyCatch;

    // Check for Arborstone fish match
    if (arborstone?.count) {
        const result = checkFishMatch(arborstone.fish, benchmark);
        if (result) return result; 
    }

    // Check for Janthir fish match
    if (janthir?.count) {
        const result = checkFishMatch(janthir.fish, benchmark);
        if (result) return result;
    }

    return false;
};

const dailyBorderColor = (fishingHole) => {
    return matchDailyCatch(fishingHole)?.color ? `1px solid ${matchDailyCatch(fishingHole).color}` : ``;
}

// Depending on if the farm is daytime or nighttime, change the background of the card
const changeTimeBackground = (time) => {
    return {
        day: time === 'Daytime',
        night: time === 'Nighttime',
        any: time === 'Anytime',
    }
}
// Reactively change the color of the 'active' and 'inactive' circle depending on what the time is
// const matchTyrianTime = (benchmarkTime) => {
//     return computed(() => tyrianCurrentPeriod.value === benchmarkTime ? 'var(--color-up)' : 'var(--color-down)').value; 
// }

const matchTyrianTime = (benchmarkTime, region) => {
    return computed(() => {
        // If fishing benchmark is CANTHAN
        if (region === 'Seitung Province' || 
            region === 'New Kaineng City' || 
            region === 'Echovald Wilds' || 
            region === "Dragon's End" || 
            region === 'Gyala Delves'
        ){
            if (canthanCurrentPeriod.value === benchmarkTime ||
                canthanCurrentPeriod.value === 'Dusk' || 
                canthanCurrentPeriod.value === 'Dawn'
            ){
                return 'Active'
                
            } else {
                return 'Inactive'
                
            }
        // else if fishing benchmark is TYRIAN
        } else {
            if (tyrianCurrentPeriod.value === benchmarkTime ||
                tyrianCurrentPeriod.value === 'Dusk' || 
                tyrianCurrentPeriod.value === 'Dawn'
            ){
                return 'Active'
            } else {
                return 'Inactive'
            }
        }
    }).value; 
}

</script>

<style scoped>
/*
    *
    * DYNAMIC CLASSES
    * For day/night fish and routes
*/
.day{
    color: var(--color-rarity-exotic);
}
.night{
    color: var(--color-rarity-legendary);
}
.any{
    color: var(--color-anytime); 
}
/*
    *
    * ACTIVE OR INACTIVE BENCHMARKS
    * When active => expand circle
*/
.Active > circle.fill-circle{
    animation: 5s infinite forwards activeSignal; 
}
.Active > circle.expand-circle{
    animation: 5s infinite forwards expandSignal;
    stroke: var(--color-expand-circle);
}
.Inactive > circle.fill-circle{
    fill: var(--color-down);
}
.Inactive > circle.expand-circle{
    display: none;
}
@keyframes activeSignal {
    0% {
        fill: var(--color-up-faded);
    }
    50% {
        fill: var(--color-up);
    }
    100% {
        fill: var(--color-up-faded);
    }
}
@keyframes expandSignal {
    0% {
        r: 5;
        stroke-opacity: 1;
    }
    50% {
        r: 10;
        stroke-opacity: 0.5;
    }
    100% {
        r: 10;
        stroke-opacity: 0;
    }
}

@media (max-width: 768px){
    .card-container{
        flex-direction: column;
    }
    .card-details{
        flex-direction: column;
        gap: unset;
    }
    .card-title-and-value{
        flex-direction: row;
        width: 100%;
    }
    .card-map-and-info{
        flex-direction: row;
        align-items: flex-end;
        width: 100%;
    }
}

</style>