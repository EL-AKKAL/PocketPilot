<script setup lang="ts">
import Separator from '@/components/ui/separator/Separator.vue';
</script>

<template>
    <footer
        id="footer"
        class="container mx-auto py-24 pb-16 sm:py-32 sm:pb-24 md:w-[70%] lg:w-[75%] lg:max-w-7xl"
    >
        <div class="rounded-2xl border bg-muted/50 p-10 dark:bg-card">
            <div
                class="grid grid-cols-2 gap-x-12 gap-y-8 md:grid-cols-4 xl:grid-cols-6"
            >
                <div class="col-span-full xl:col-span-2">
                    <a
                        href="/"
                        class="flex h-10! items-center text-xl font-extrabold!"
                    >
                        <img src="./logo.svg" class="w-10 px-0! lg:w-16" />
                        <span class="font-extrabold">Pocket</span
                        ><span class="text-primary">Pilot</span>
                    </a>
                </div>

                <div class="flex flex-col gap-2">
                    <h3 class="text-lg font-bold">Contact</h3>
                    <div>
                        <a
                            href="https://github.com/EL-AKKAL"
                            target="_blank"
                            class="opacity-60 hover:opacity-100"
                        >
                            Github
                        </a>
                    </div>

                    <div>
                        <a
                            href="https://www.linkedin.com/in/ayoub-akkal/"
                            target="_blank"
                            class="opacity-60 hover:opacity-100"
                        >
                            LinkedIn
                        </a>
                    </div>

                    <div>
                        <a
                            href="mailto:akkalayoub3@gmail.com"
                            class="opacity-60 hover:opacity-100"
                        >
                            Gmail
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <h3 class="text-lg font-bold">Tech Stack</h3>
                    <div>
                        <a
                            href="https://laravel.com"
                            target="_blank"
                            class="opacity-60 hover:opacity-100"
                        >
                            Laravel
                        </a>
                    </div>

                    <div>
                        <a
                            href="https://inertiajs.com"
                            target="_blank"
                            class="opacity-60 hover:opacity-100"
                        >
                            Inertia.js
                        </a>
                    </div>

                    <div>
                        <a
                            href="https://vuejs.org"
                            target="_blank"
                            class="opacity-60 hover:opacity-100"
                        >
                            Vue.js
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <h3 class="text-lg font-bold">Resources</h3>

                    <div>
                        <a
                            href="#features"
                            class="opacity-60 hover:opacity-100"
                        >
                            Features
                        </a>
                    </div>

                    <div>
                        <a
                            href="#how-it-works"
                            class="opacity-60 hover:opacity-100"
                        >
                            How It Works
                        </a>
                    </div>

                    <div>
                        <a
                            href="#community"
                            class="opacity-60 hover:opacity-100"
                        >
                            Get Started
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <h3 class="text-lg font-bold">Support</h3>
                    <div>
                        <a
                            href="mailto:akkalayoub3@gmail.com"
                            target="_blank"
                            class="opacity-60 hover:opacity-100"
                        >
                            Contact
                        </a>
                    </div>

                    <div>
                        <a href="#faq" class="opacity-60 hover:opacity-100">
                            FAQ
                        </a>
                    </div>

                    <div>
                        <a
                            href="https://github.com/EL-AKKAL/PocketPilot/issues"
                            target="_blank"
                            class="opacity-60 hover:opacity-100"
                        >
                            Report Issue
                        </a>
                    </div>
                </div>
            </div>

            <Separator class="my-6" />
            <section>
                <h3 class="">
                    &copy; {{ new Date().getFullYear() }} Landing. Designed by
                    <a
                        target="_blank"
                        href="https://github.com/leoMirandaa"
                        class="border-primary text-primary transition-all hover:border-b-2"
                    >
                        Leo Miranda
                    </a>
                    Project built by
                    <a
                        target="_blank"
                        href="https://github.com/EL-AKKAL"
                        class="border-primary text-primary transition-all hover:border-b-2"
                    >
                        Ayoub ELAKKAL
                    </a>
                    all rights reserved.
                </h3>
            </section>
        </div>
    </footer>
</template>
