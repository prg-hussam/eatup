<script setup></script>

<template>
    <ul
        class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0"
        role="tablist"
    >
        <li class="nav-item">
            <a
                class="nav-link active"
                data-bs-toggle="tab"
                href="#profileInformation"
                role="tab"
            >
                <i class="bx bxs-user"></i>
                {{ $t("admin.my_account.profile_information") }}
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link"
                data-bs-toggle="tab"
                href="#changePassword"
                role="tab"
            >
                <i class="bx bxs-key"></i>
                {{ $t("admin.my_account.change_password") }}
            </a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link"
                data-bs-toggle="tab"
                href="#privacyPolicy"
                role="tab"
            >
                <i class="bx bxs-check-shield"></i>
                {{ $t("admin.my_account.privacy_policy") }}
            </a>
        </li>
    </ul>
</template>
