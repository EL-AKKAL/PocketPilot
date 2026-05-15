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
                        <a href="#" class="opacity-60 hover:opacity-100">
                            Github
                        </a>
                    </div>

                    <div>
                        <a href="#" class="opacity-60 hover:opacity-100">
                            Twitter
                        </a>
                    </div>

                    <div>
                        <a href="#" class="opacity-60 hover:opacity-100">
                            Instagram
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <h3 class="text-lg font-bold">Platforms</h3>
                    <div>
                        <a href="#" class="opacity-60 hover:opacity-100">
                            iOS
                        </a>
                    </div>

                    <div>
                        <a href="#" class="opacity-60 hover:opacity-100">
                            Android
                        </a>
                    </div>

                    <div>
                        <a href="#" class="opacity-60 hover:opacity-100">
                            Web
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <h3 class="text-lg font-bold">Help</h3>
                    <div>
                        <a href="#" class="opacity-60 hover:opacity-100">
                            Contact Us
                        </a>
                    </div>

                    <div>
                        <a href="#" class="opacity-60 hover:opacity-100">
                            FAQ
                        </a>
                    </div>

                    <div>
                        <a href="#" class="opacity-60 hover:opacity-100">
                            Feedback
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <h3 class="text-lg font-bold">Socials</h3>
                    <div>
                        <a href="#" class="opacity-60 hover:opacity-100">
                            Twitch
                        </a>
                    </div>

                    <div>
                        <a href="#" class="opacity-60 hover:opacity-100">
                            Discord
                        </a>
                    </div>

                    <div>
                        <a href="#" class="opacity-60 hover:opacity-100">
                            Dribbble
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
