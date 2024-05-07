<template>
    <CardContainer title="Keys" collapsable>
        <div class="px-4 py-2">
            <header class="py-2">
                <p class="font-bold">
                    Manage your keys to login easily without using a password.
                </p>
            </header>

            <div class="py-2"></div>

            <div class="py-2">
                <BaseButton class="my-2" @click="generateKeys">Generate Keys</BaseButton>
                <BaseButton class="my-2 mx-4" @click="uploadKey" disabled>Upload File</BaseButton>
            </div>
        </div>
    </CardContainer>
</template>

<script setup lang="ts">
import BaseButton from "@/components/BaseButton.vue";
import CardContainer from "@/components/CardContainer.vue";
import PublicCrypto from "@/helpers/crypto";

async function generateKeys() {
    try {
        const cryptoPair = new PublicCrypto();
        cryptoPair.uploadPublicKey();
        // cryptoPair.downloadPrivateKey();
    } catch (e) {
        console.log((e as Error).message);
    }
}

async function uploadKey() {
    //
}
</script>
