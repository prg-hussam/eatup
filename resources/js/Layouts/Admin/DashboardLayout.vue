<script>
import Header from "./Partials/Header.vue";
import Sidebar from "./Partials/Sidebar/Index.vue";
import Footer from "./Partials/Footer.vue";
import VisitModal from "@/Shared/Admin/VisitModal.vue";
import FileManagerModal from "@/Shared/Admin/FileManagerModal.vue";
export default {
    components: { Header, Sidebar, VisitModal, Footer, FileManagerModal },
    data() {
        return {
            scTimer: 0,
            scY: 0,
        };
    },

    mounted() {
        window.addEventListener("scroll", this.handleScroll);
    },

    methods: {
        handleScroll: function () {
            if (this.scTimer) return;
            this.scTimer = setTimeout(() => {
                this.scY = window.scrollY;
                clearTimeout(this.scTimer);
                this.scTimer = 0;
            }, 100);
        },
        toTop: function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        },
    },
    watch: {
        "$page.url": function (newUrl, oldUrl) {
            let body = document.getElementsByTagName("body")[0];
            if (document.querySelector(".modal-backdrop")) {
                document.querySelector(".modal-backdrop").remove();
                body.removeAttribute("style");
                body.classList.remove("modal-open");
            }

            if (document.querySelector(".vertical-sidebar-enable")) {
                body.classList.remove("vertical-sidebar-enable");
            }

            if (document.querySelector('[data-bs-toggle="popover"]')) {
                document.querySelector('[data-bs-toggle="popover"]').click();
            }
        },
    },
};
</script>

<template>
    <div id="layout-wrapper">
        <Header />
        <Sidebar />

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div v-if="$slots.breadcrumb" class="row">
                        <div class="col-12">
                            <slot name="breadcrumb" />
                        </div>
                    </div>
                    <slot name="content" />
                </div>
            </div>
            <VisitModal />
            <FileManagerModal />
            <Footer />
        </div>

        <transition name="fade">
            <button
                v-show="scY > 300"
                @click="toTop"
                class="btn btn-danger btn-icon"
                id="back-to-top"
            >
                <i class="mdi mdi-arrow-up"></i>
            </button>
        </transition>
    </div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
