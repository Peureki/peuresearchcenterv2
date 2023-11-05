<template>
    <Nav/>
    <main>
        <Header
            page-name="Spirit Shards"
        />

        <div v-for="recipe in recipes">
            <SpiritShardsFineTable
                table-name="T2"
                :recipe="recipe"
            />
            
        </div>
        
    </main>
    
</template>

<script setup>

import Nav from '@/js/vue/components/general/Nav.vue'
import Header from '@/js/vue/components/general/Header.vue'

import SpiritShardsFineTable from '@/js/vue/components/tables/SpiritShardsFineTable.vue'

import { getSpiritShards } from '@/js/vue/composables/TableFunctions'

let recipes = {
    fineT2: [
        {
            name: "Bone Shard",
            id: 24343,
            ingredients: [
                {
                    item_id: 24342,
                    count: 50,
                },
                {
                    item_id: 24343,
                    count: 1,
                },
                {
                    item_id: 24273,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/E2EC91117128DC5BC0B0FA0267EBBC2429B3556F/66989.png",
        },
        {
            name: "Small Scale",
            id: 24285,
            ingredients: [
                {
                    item_id: 24284,
                    count: 50,
                },
                {
                    item_id: 24285,
                    count: 1,
                },
                {
                    item_id: 24273,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/EE0C5C5917BE5B0F1569134E40E80399FFC73E17/66941.png",
        },
        {
            name: "Small Totem",
            id: 24297,
            ingredients: [
                {
                    item_id: 24296,
                    count: 50,
                },
                {
                    item_id: 24297,
                    count: 1,
                },
                {
                    item_id: 24273,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/ABE928F56C08C9ED47664948EB30A25B08DC5DEF/66952.png",
        },
        {
            name: "Pile of Shimmering Dust",
            id: 24273,
            ingredients: [
                {
                    item_id: 24272,
                    count: 50,
                },
                {
                    item_id: 24273,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
                {
                    item_id: 20796,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/33653CA0C67796BE03A22B5AE3197D0564376700/434533.png",
        },
        {
            name: "Small Venom Sac",
            id: 24279,
            ingredients: [
                {
                    item_id: 24278,
                    count: 50,
                },
                {
                    item_id: 24279,
                    count: 1,
                },
                {
                    item_id: 24273,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/0C04FDFF465A682BB080F272E9DB3DBC0637113D/66935.png",
        },
        {
            name: "Vial of Thin Blood",
            id: 24291,
            ingredients: [
                {
                    item_id: 24290,
                    count: 50,
                },
                {
                    item_id: 24291,
                    count: 1,
                },
                {
                    item_id: 24273,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/3008755732C166F3ACF87CC044779C5D95D25896/66946.png",
        },
        {
            name: "Small Claw",
            id: 24347,
            ingredients: [
                {
                    item_id: 24346,
                    count: 50,
                },
                {
                    item_id: 24347,
                    count: 1,
                },
                {
                    item_id: 24273,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/4CFEC931B41FA0092E5C9B6F240FE1F64E2F5247/66993.png",
        },
        {
            name: "Small Fang",
            id: 24353,
            ingredients: [
                {
                    item_id: 24352,
                    count: 50,
                },
                {
                    item_id: 24353,
                    count: 1,
                },
                {
                    item_id: 24273,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/58E20991EB9BA6D4954DAFC6AF4B3CE3C8EB7116/220904.png",
        },
    ],
    fineT3: [
        {
            name: "Bone",
            id: 24344,
            ingredients: [
                {
                    item_id: 24343,
                    count: 50,
                },
                {
                    item_id: 24344,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 2,
                },
            ],
            icon: "https://render.guildwars2.com/file/B000AA18322202719E2B251B4EE735B5D3EF4EB1/66990.png",
        },
        {
            name: "Scale",
            id: 24286,
            ingredients: [
                {
                    item_id: 24285,
                    count: 50,
                },
                {
                    item_id: 24286,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 2,
                },
            ],
            icon: "https://render.guildwars2.com/file/14C880782A481EE8051BDB176E542AF55C6CE663/66942.png",
        },
        {
            name: "Totem",
            id: 24298,
            ingredients: [
                {
                    item_id: 24297,
                    count: 50,
                },
                {
                    item_id: 24298,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 2,
                },
            ],
            icon: "https://render.guildwars2.com/file/52A92F9505FD49FB655A0631525556D5B80E55C0/66953.png",
        },
        {
            name: "Pile of Radiant Dust",
            id: 24274,
            ingredients: [
                {
                    item_id: 24273,
                    count: 250,
                },
                {
                    item_id: 24274,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 2,
                },
                {
                    item_id: 20796,
                    count: 2,
                },
            ],
            icon: "https://render.guildwars2.com/file/3F95D5E3E1B07294C7625B36004F6AE76C05E117/434534.png",
        },
        {
            name: "Venom Sac",
            id: 24280,
            ingredients: [
                {
                    item_id: 24279,
                    count: 50,
                },
                {
                    item_id: 24280,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 2,
                },
            ],
            icon: "https://render.guildwars2.com/file/6D1AB79FCCD5E673A0220A39C56E45081B426019/66936.png",
        },
        {
            name: "Vial of Blood",
            id: 24292,
            ingredients: [
                {
                    item_id: 24291,
                    count: 50,
                },
                {
                    item_id: 24292,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 2,
                },
            ],
            icon: "https://render.guildwars2.com/file/7D0B2A322001D999514908D519590D9B5D04DB35/66947.png",
        },
        {
            name: "Claw",
            id: 24348,
            ingredients: [
                {
                    item_id: 24347,
                    count: 50,
                },
                {
                    item_id: 24348,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 2,
                },
            ],
            icon: "https://render.guildwars2.com/file/325E12790C72C161E15B1CCE253C6079960CA138/66994.png",
        },
        {
            name: "Fang",
            id: 24354,
            ingredients: [
                {
                    item_id: 24353,
                    count: 50,
                },
                {
                    item_id: 24354,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 2,
                },
            ],
            icon: "https://render.guildwars2.com/file/112DF0DE564C9C061FE8DDB198EA953ED527E9D6/66809.png",
        },
    ],
    fineT4: [
        {
            name: "Heavy Bone",
            id: 24345,
            ingredients: [
                {
                    item_id: 24344,
                    count: 50,
                },
                {
                    item_id: 24345,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 3,
                },
            ],
            icon: "https://render.guildwars2.com/file/A27457964A7F0A19DFFCA57FCB7308D233FE66E1/66991.png",
        },
        {
            name: "Smooth Scale",
            id: 24287,
            ingredients: [
                {
                    item_id: 24286,
                    count: 50,
                },
                {
                    item_id: 24287,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 3,
                },
            ],
            icon: "https://render.guildwars2.com/file/95F72F7A1A3D6D01751148FF3D0D9709366F203B/66943.png",
        },
        {
            name: "Engraved Totem",
            id: 24363,
            ingredients: [
                {
                    item_id: 24298,
                    count: 50,
                },
                {
                    item_id: 24363,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 3,
                },
            ],
            icon: "https://render.guildwars2.com/file/AB3AC996CC791BE0FF784CDC57060F05E6D23020/67000.png",
        },
        {
            name: "Pile of Luminous Dust",
            id: 24275,
            ingredients: [
                {
                    item_id: 24274,
                    count: 250,
                },
                {
                    item_id: 24275,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 3,
                },
                {
                    item_id: 20796,
                    count: 3,
                },
            ],
            icon: "https://render.guildwars2.com/file/DDCA6504E718CA6DFF08F1483A2F356D0F4AEB4A/434535.png",
        },
        {
            name: "Full Venom Sac",
            id: 24281,
            ingredients: [
                {
                    item_id: 24280,
                    count: 50,
                },
                {
                    item_id: 24281,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 3,
                },
            ],
            icon: "https://render.guildwars2.com/file/FE3D2BD0B88077ACE7E808504A3ACB0C4EDAD8D5/66937.png",
        },
        {
            name: "Vial of Thick Blood",
            id: 24293,
            ingredients: [
                {
                    item_id: 24292,
                    count: 50,
                },
                {
                    item_id: 24293,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 3,
                },
            ],
            icon: "https://render.guildwars2.com/file/5103E44DB05DE7A9579C98037332294DB209CB72/66948.png",
        },
        {
            name: "Sharp Claw",
            id: 24349,
            ingredients: [
                {
                    item_id: 24348,
                    count: 50,
                },
                {
                    item_id: 24349,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 3,
                },
            ],
            icon: "https://render.guildwars2.com/file/97BCA6B90E56E6F0A06B3C031CDEA5EC0EBA17B5/66995.png",
        },
        {
            name: "Sharp Fang",
            id: 24355,
            ingredients: [
                {
                    item_id: 24354,
                    count: 50,
                },
                {
                    item_id: 24355,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 3,
                },
            ],
            icon: "https://render.guildwars2.com/file/5F9923611B4B5314D5993872EC2970CA7BE09DAB/65896.png",
        },
    ],
    fineT5: [
        {
            name: "Large Bone",
            id: 24341,
            ingredients: [
                {
                    item_id: 24345,
                    count: 50,
                },
                {
                    item_id: 24341,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 4,
                },
            ],
            icon: "https://render.guildwars2.com/file/13F077BA5D5C6324CFCB0A2E39050F24A441190B/66987.png",
        },
        {
            name: "Large Scale",
            id: 24288,
            ingredients: [
                {
                    item_id: 24287,
                    count: 50,
                },
                {
                    item_id: 24288,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 4,
                },
            ],
            icon: "https://render.guildwars2.com/file/F94ECFFF0FA9C321C108DA34E777B27B0AC9D5F8/66944.png",
        },
        {
            name: "Intricate Totem",
            id: 24299,
            ingredients: [
                {
                    item_id: 24363,
                    count: 50,
                },
                {
                    item_id: 24299,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 4,
                },
            ],
            icon: "https://render.guildwars2.com/file/4DBC299E4B036A0DD3119A0F06BACA147C03B5C7/66954.png",
        },
        {
            name: "Pile of Incandescent Dust",
            id: 24276,
            ingredients: [
                {
                    item_id: 24275,
                    count: 250,
                },
                {
                    item_id: 24276,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 4,
                },
                {
                    item_id: 20796,
                    count: 4,
                },
            ],
            icon: "https://render.guildwars2.com/file/3501C2BBADF95BE5F14E31484850E851EFCA33CB/434536.png",
        },
        {
            name: "Potent Vemon Sac",
            id: 24282,
            ingredients: [
                {
                    item_id: 24281,
                    count: 50,
                },
                {
                    item_id: 24282,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 4,
                },
            ],
            icon: "https://render.guildwars2.com/file/EA6A4C91F561EC5667947AEFE4CA436D0631CBE3/66938.png",
        },
        {
            name: "Vial of Potent Blood",
            id: 24294,
            ingredients: [
                {
                    item_id: 24293,
                    count: 50,
                },
                {
                    item_id: 24294,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 4,
                },
            ],
            icon: "https://render.guildwars2.com/file/99AAE49EABF9A2415940FDB83CA1CE5E6E256020/66949.png",
        },
        {
            name: "Large Claw",
            id: 24350,
            ingredients: [
                {
                    item_id: 24349,
                    count: 50,
                },
                {
                    item_id: 24350,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 4,
                },
            ],
            icon: "https://render.guildwars2.com/file/3A4D64F4CE2951F358DE0AFCEA6551050FB4B4A7/66420.png",
        },
        {
            name: "Large Fang",
            id: 24356,
            ingredients: [
                {
                    item_id: 24355,
                    count: 50,
                },
                {
                    item_id: 24356,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 4,
                },
            ],
            icon: "https://render.guildwars2.com/file/DED4F23E44430C2BE1C0D491145A4946FC7D7C6F/223793.png",
        },
    ],
    fineT6: [
        {
            name: "Ancient Bone",
            id: 24358,
            ingredients: [
                {
                    item_id: 24341,
                    count: 50,
                },
                {
                    item_id: 24358,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 5,
                },
            ],
            icon: "https://render.guildwars2.com/file/0EE45FBB1E1A004600E9BAA7097830B2DE08587D/66828.png",
        },
        {
            name: "Armored Scale",
            id: 24289,
            ingredients: [
                {
                    item_id: 24288,
                    count: 50,
                },
                {
                    item_id: 24289,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 5,
                },
            ],
            icon: "https://render.guildwars2.com/file/7061C82F4F9D0C585742F545C40A0F06BE0154DC/66527.png",
        },
        {
            name: "Elaborate Totem",
            id: 24300,
            ingredients: [
                {
                    item_id: 24299,
                    count: 50,
                },
                {
                    item_id: 24300,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 5,
                },
            ],
            icon: "https://render.guildwars2.com/file/C1ABF9082901FC3CEABC3138CBCCA1DAD5D41812/66955.png",
        },
        {
            name: "Pile of Crystalline Dust",
            id: 24277,
            ingredients: [
                {
                    item_id: 24276,
                    count: 250,
                },
                {
                    item_id: 24277,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 5,
                },
            ],
            icon: "https://render.guildwars2.com/file/080D00670558CD9E580D5662030394B2206E92A6/434537.png",
        },
        {
            name: "Powerful Venom Sac",
            id: 24283,
            ingredients: [
                {
                    item_id: 24282,
                    count: 50,
                },
                {
                    item_id: 24283,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 5,
                },
            ],
            icon: "https://render.guildwars2.com/file/543EC37900EA2A57E77FA891193A48D66AA224AB/66939.png",
        },
        {
            name: "Vial of Powerful Blood",
            id: 24295,
            ingredients: [
                {
                    item_id: 24294,
                    count: 50,
                },
                {
                    item_id: 24295,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 5,
                },
            ],
            icon: "https://render.guildwars2.com/file/1A930A6A7B5B01EAB4CB36E79014C12B500BF6B3/66950.png",
        },
        {
            name: "Vicious Claw",
            id: 24351,
            ingredients: [
                {
                    item_id: 24350,
                    count: 50,
                },
                {
                    item_id: 24351,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 5,
                },
            ],
            icon: "https://render.guildwars2.com/file/043E2BBA270F381870F1B45E7C09C098CAFE3D14/66996.png",
        },
        {
            name: "Vicious Fang",
            id: 24357,
            ingredients: [
                {
                    item_id: 24356,
                    count: 50,
                },
                {
                    item_id: 24357,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 5,
                },
                {
                    item_id: 20796,
                    count: 5,
                },
            ],
            icon: "https://render.guildwars2.com/file/F2050EE1A7A43EDCDCB1E971FDA608AD0566E4DA/66998.png",
        },
    ],
    // *
    // * RARE CRAFTING MATERIALS 
    // *
    rareT2: [
        {
            name: "Charged Fragment",
            id: 24302,
            ingredients: [
                {
                    item_id: 24301,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/3E2CD04924CFA55FEBF9614DA490D7AE660C1D24/66956.png",
        },
        {
            name: "Corrupted Fragment",
            id: 24337,
            ingredients: [
                {
                    item_id: 24336,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/7A492E71E419ECFD94D8A2B1400A09A0C20373CE/66983.png",
        },
        {
            name: "Crystal Fragment",
            id: 24327,
            ingredients: [
                {
                    item_id: 24326,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/43D43127072CF33D58B25E2FCC940435EB3D4548/66978.png",
        },
        {
            name: "Destroyer Fragment",
            id: 24322,
            ingredients: [
                {
                    item_id: 24321,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/EF65D6D16101C608709619BAE2045E00511E7CD5/66973.png",
        },
        {
            name: "Glacial Fragment",
            id: 24317,
            ingredients: [
                {
                    item_id: 24316,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/6909C7740DF404434BA1D32E4F7042D050FF7FE7/63150.png",
        },
        {
            name: "Molten Fragment",
            id: 24318,
            ingredients: [
                {
                    item_id: 24311,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/C3FD9D339FFF55543CB33643C91B0E4BA9D2F4A4/65591.png",
        },
        {
            name: "Onyx Fragment",
            id: 24307,
            ingredients: [
                {
                    item_id: 24306,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24274,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/C9F32DD525689EC3ADABDD7B633F1815A2C93080/66960.png",
        },
    ],
    rareT3: [
        {
            name: "Charged Shard",
            id: 24303,
            ingredients: [
                {
                    item_id: 24302,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/306AB62DEBCD6D02113CD0730BDC6F95BA9B9AC4/65587.png",
        },
        {
            name: "Corrupted Shard",
            id: 24338,
            ingredients: [
                {
                    item_id: 24337,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/08AF9D2A7576FA66BEC322A859ADA0DFF7BA4B0E/66984.png",
        },
        {
            name: "Crystal Shard",
            id: 24328,
            ingredients: [
                {
                    item_id: 24327,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/2EDD405D1DF17EB01192982A3F9CF59090D7A617/65590.png",
        },
        {
            name: "Destroyer Shard",
            id: 24323,
            ingredients: [
                {
                    item_id: 24322,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/51F010BBE69639210416F8E436C00177670C5847/66974.png",
        },
        {
            name: "Glacial Shard",
            id: 24318,
            ingredients: [
                {
                    item_id: 24317,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/C3FD9D339FFF55543CB33643C91B0E4BA9D2F4A4/65591.png",
        },
        {
            name: "Molten Shard",
            id: 24313,
            ingredients: [
                {
                    item_id: 24312,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/F7A947B33B0710FF2D34EAD478E7C9C430A4CFE4/66966.png",
        },
        {
            name: "Onyx Shard",
            id: 24308,
            ingredients: [
                {
                    item_id: 24307,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24275,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/F0C133B3E8FADB3C070DA35C015551A7E50692F8/66961.png",
        },
    ],
    rareT4: [
        {
            name: "Charged Core",
            id: 24304,
            ingredients: [
                {
                    item_id: 24303,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/3903CB74F8D64657FFCCAADB934AF42DFB941E6C/66957.png",
        },
        {
            name: "Corrupted Core",
            id: 24339,
            ingredients: [
                {
                    item_id: 24338,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/31E8DC797FD7369A2824AAB76D414350FFABED95/66985.png",
        },
        {
            name: "Crystal Core",
            id: 24329,
            ingredients: [
                {
                    item_id: 24328,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/D75C7D66B6589636E00AA45B20EB061305B5C52B/66979.png",
        }, 
        {
            name: "Destroyer Core",
            id: 24324,
            ingredients: [
                {
                    item_id: 24324,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/D59CDF80A1C9C061ED729C78BAA5980DAC75BE4C/66975.png",
        },
        {
            name: "Glacial Core",
            id: 24319,
            ingredients: [
                {
                    item_id: 24318,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/7C5BF3B99647E2AB0E0F6C18B60CD5743D21BADC/66970.png",
        },
        {
            name: "Molten Core",
            id: 24314,
            ingredients: [
                {
                    item_id: 24313,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/F23608C7DE13B2BC903D3F6EB9734B423E96A6CB/66967.png",
        },
        {
            name: "Onyx Core",
            id: 24309,
            ingredients: [
                {
                    item_id: 24308,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24276,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/EDE00E4F3F3802F8064D7640A345ADA0E85D045C/66962.png",
        },
    ],
    rareT5: [
        {
            name: "Charged Lodestone",
            id: 24305,
            ingredients: [
                {
                    item_id: 24304,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/02EFB1C5E11B2FF4B4AC25A84E2302D244C82AA3/66958.png",
        },
        {
            name: "Corrupted Lodestone",
            id: 24340,
            ingredients: [
                {
                    item_id: 24339,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/CCC31822DA0D7D930D067B17C958A5CB1F4A24A5/66986.png",
        },
        {
            name: "Crystal Lodestone",
            id: 24330,
            ingredients: [
                {
                    item_id: 24329,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/C10553036839522AAB54425B431E391F76D878AC/66980.png",
        },
        {
            name: "Destroyer Lodestone",
            id: 24325,
            ingredients: [
                {
                    item_id: 24324,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/77BE2565DD345ADFEF3850A5B647FE50C144AAF8/66976.png",
        },
        {
            name: "Glacial Lodestone",
            id: 24320,
            ingredients: [
                {
                    item_id: 24319,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/E6FE2939F9BE1E03B4CD32B8492D3EDC407C0F75/66971.png",
        },
        {
            name: "Molten Lodestone",
            id: 24315,
            ingredients: [
                {
                    item_id: 24314,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/76910A3A41C33D0FF09EF3CBDA4B079706150FB9/66968.png",
        },
        {
            name: "Onyx Lodestone",
            id: 24310,
            ingredients: [
                {
                    item_id: 24310,
                    count: 2,
                },
                {
                    item_id: 19663,
                    count: 1,
                },
                {
                    item_id: 24277,
                    count: 1,
                },
                {
                    item_id: 20799,
                    count: 1,
                },
            ],
            icon: "https://render.guildwars2.com/file/2232AA41E3DF20EB249C0B6D10BC0D37FF6C0E3D/66963.png",
        },
    ],
}


</script>