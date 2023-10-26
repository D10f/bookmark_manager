<template>
    <Head>
        <meta name="description" head-key="description" content="A modern bookmark manager for the DIY enthusiasts." />
    </Head>
    <div class="bg-slate-700 text-white min-h-screen p-1">
        <main class="flex flex-col justify-between gap-2 relative z-10">
            <slot />
        </main>

        <div
            class="fixed blur-2xl w-96 h-24 bg-cyan-400 top-1/4 left-1/3 rounded-full animate-[spin_200s_linear_infinite]" />

        <div
            class="fixed blur-xl w-16 h-16 bg-yellow-100/20 top-1/4 left-1/3 rounded-full animate-[pulse_40s_linear_infinite]" />

        <div
            class="fixed blur-xl w-32 h-32 bg-purple-800 bottom-64 left-48 rounded-full animate-[pulse_30s_linear_infinite]" />

        <div
            class="fixed blur-xl w-32 h-32 bg-fuchsia-400 bottom-24 left-12 rounded-full animate-[pulse_30s_linear_infinite]" />

        <div
            class="fixed blur-xl w-64 h-64 bg-pink-500 bottom-24 left-10 rounded-full animate-[pulse_40s_linear_infinite]" />
    </div>
</template>
