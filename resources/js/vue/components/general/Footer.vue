<template>
    <section class="main">
        <div class="content-section">
            <Disclaimer
                message="The choyas are working hard to build this website. This is an 'early release'. To check patch notes, check out the #prc-patch-notes channel on Discord. Version 0.3.0"
            />
        </div>
        
    </section>

    <footer>
        <section class="main">
            <div class="content-section">
                <div class="footer-container">
                    <p class="small-subtitle">© ArenaNet LLC. All rights reserved. NCSOFT, ArenaNet, Guild Wars, Guild Wars 2, GW2, Guild Wars 2: Heart of Thorns, Guild Wars 2: Path of Fire, Guild Wars 2: End of Dragons, and Guild Wars 2: Secrets of the Obscure and all associated logos, designs, and composite marks are trademarks or registered trademarks of NCSOFT Corporation.</p>

                    <p class="small-subtitle temp-merp">Created by Peureki.3647</p>
                </div>
                
            </div>
            
        </section>
        
    </footer>
    
</template>

<script setup>

import Disclaimer from '@/js/vue/components/general/Disclaimer.vue'

</script>

<style scoped>
.footer-container{
    display: flex;
    gap: var(--gap-general);
}
.footer-container > *{
    flex: 1;
}
.temp-merp{
    text-align: right;
}

@media (max-width: 768px){
    .footer-container{
        flex-direction: column;
    }
}

</style>