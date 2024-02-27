<template>
    <div>
        <div id="projects" class="sticky top-0 backdrop-blur-sm bg-slate/30">
            <h4 class="flex items-center py-3 mb-3 uppercase text-lg font-medium tracking-tight text-slate-200 sm:text-xl">
                <span class="w-16 bg-slate-200 h-px mr-4"></span>
                <span>projets</span>
            </h4>
        </div>
        <ol class="flex flex-col gap-y-4 group/list">
            <!-- <li v-for="project in projects" class="">
                <div class="flex">
                    <div class="">
                        <img :src="project.logo" :alt="project.title" class="w-full h-60 object-cover rounded-lg">
                    </div>
                    <div class="">
                        <div class="">{{ project.title }}</div>
                        <div class="">{{ project.client }}</div>
                        <div class="">{{ project.job }}</div>
                    </div>
                </div>
            </li> -->
            <li class="mb-12">
                <div class="group relative grid pb-1 transition-all sm:grid-cols-8 sm:gap-8 md:gap-4 lg:hover:!opacity-100 lg:group-hover/list:opacity-50">
                    <div class="absolute -inset-x-4 -inset-y-4 z-0 hidden rounded-md transition motion-reduce:transition-none lg:-inset-x-6 lg:block lg:group-hover:bg-slate-800/50 lg:group-hover:shadow-[inset_0_1px_0_0_rgba(148,163,184,0.1)] lg:group-hover:drop-shadow-lg">
                    </div>
                    <header class="z-10 mb-2 mt-1 text-xs font-semibold uppercase tracking-wide text-slate-500 sm:col-span-2" aria-label="2018 to Present">2018 — Present</header>
                    <div class="z-10 sm:col-span-6">
                        <h3 class="font-medium leading-snug text-slate-200">
                            <div><a class="inline-flex items-baseline font-medium leading-tight text-slate-200 hover:text-teal-300 focus-visible:text-teal-300  group/link text-base"
                                    href="https://upstatement.com" target="_blank" rel="noreferrer noopener"
                                    aria-label="Lead Engineer at Upstatement (opens in a new tab)"><span
                                        class="absolute -inset-x-4 -inset-y-2.5 hidden rounded md:-inset-x-6 md:-inset-y-4 lg:block"></span><span>Lead
                                        Engineer ·<!-- --> <span class="inline-block">Upstatement<svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="inline-block h-4 w-4 shrink-0 transition-transform group-hover/link:-translate-y-1 group-hover/link:translate-x-1 group-focus-visible/link:-translate-y-1 group-focus-visible/link:translate-x-1 motion-reduce:transition-none ml-1 translate-y-px"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.22 14.78a.75.75 0 001.06 0l7.22-7.22v5.69a.75.75 0 001.5 0v-7.5a.75.75 0 00-.75-.75h-7.5a.75.75 0 000 1.5h5.69l-7.22 7.22a.75.75 0 000 1.06z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div>
                            <div class="text-slate-500" aria-hidden="true">Senior Engineer</div>
                        </div>
                        <div>
                            <div class="text-slate-500" aria-hidden="true">Engineer</div>
                        </div>
                    </h3>
                    <p class="mt-2 text-sm leading-normal">Build, style, and ship high-quality websites, design systems,
                        mobile apps, and digital experiences for a diverse array of projects for clients including
                        Harvard Business School, Everytown for Gun Safety, Pratt Institute, Koala Health, Vanderbilt
                        University, The 19th News, and more. Provide leadership within engineering department through
                        close collaboration, knowledge shares, and spearheading the development of internal tools.</p>
                    <ul class="mt-2 flex flex-wrap" aria-label="Technologies used">
                        <li class="mr-1.5 mt-2">
                            <div
                                class="flex items-center rounded-full bg-teal-400/10 px-3 py-1 text-xs font-medium leading-5 text-teal-300 ">
                                JavaScript</div>
                        </li>
                        <li class="mr-1.5 mt-2">
                            <div
                                class="flex items-center rounded-full bg-teal-400/10 px-3 py-1 text-xs font-medium leading-5 text-teal-300 ">
                                TypeScript</div>
                        </li>
                        <li class="mr-1.5 mt-2">
                            <div
                                class="flex items-center rounded-full bg-teal-400/10 px-3 py-1 text-xs font-medium leading-5 text-teal-300 ">
                                HTML &amp; SCSS</div>
                        </li>
                        <li class="mr-1.5 mt-2">
                            <div
                                class="flex items-center rounded-full bg-teal-400/10 px-3 py-1 text-xs font-medium leading-5 text-teal-300 ">
                                React</div>
                        </li>
                        <li class="mr-1.5 mt-2">
                            <div
                                class="flex items-center rounded-full bg-teal-400/10 px-3 py-1 text-xs font-medium leading-5 text-teal-300 ">
                                Next.js</div>
                        </li>
                        <li class="mr-1.5 mt-2">
                            <div
                                class="flex items-center rounded-full bg-teal-400/10 px-3 py-1 text-xs font-medium leading-5 text-teal-300 ">
                                React Native</div>
                        </li>
                        <li class="mr-1.5 mt-2">
                            <div
                                class="flex items-center rounded-full bg-teal-400/10 px-3 py-1 text-xs font-medium leading-5 text-teal-300 ">
                                WordPress</div>
                        </li>
                        <li class="mr-1.5 mt-2">
                            <div
                                class="flex items-center rounded-full bg-teal-400/10 px-3 py-1 text-xs font-medium leading-5 text-teal-300 ">
                                Contentful</div>
                        </li>
                        <li class="mr-1.5 mt-2">
                            <div
                                class="flex items-center rounded-full bg-teal-400/10 px-3 py-1 text-xs font-medium leading-5 text-teal-300 ">
                                Node.js</div>
                        </li>
                        <li class="mr-1.5 mt-2">
                            <div
                                class="flex items-center rounded-full bg-teal-400/10 px-3 py-1 text-xs font-medium leading-5 text-teal-300 ">
                                PHP</div>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    </ol>
</div></template>

<script>
export default {
    props: {
        projects: {
            type: Object,
        },
    },
}
</script>
