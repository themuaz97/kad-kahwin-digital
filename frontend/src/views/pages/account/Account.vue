<template>
  <div class="flex flex-col items-center">
    <!-- Left Spacer -->
    <div class="hidden lg:flex flex-1"></div>

    <ConfirmDialog />
    <div class="flex flex-col w-full lg:w-2/4 gap-8">
      <h1 class="md:text-3xl font-semibold">Account Settings</h1>
      <Card>
        <template #title>
          <div class="hidden sm:block">
            Personal Information
          </div>
        </template>
        <template #content>
          <PersonalInfo />
        </template>
      </Card>

      <!-- <Card v-if="authStore.user?.sso_providers.some(provider => provider.provider === 'internal')">
        <template #title>
          Update Password
        </template>
        <template #content>
          <UpdatePassword />
        </template>
      </Card>

      <div
        v-else-if="authStore.user?.sso_providers.some(provider => provider.provider === 'internal') && authStore.user?.sso_providers.some(provider => provider.provider !== 'internal')"
        class="flex flex-col gap-8">
        <Card>
          <template #title>
            Social Profile
          </template>
          <template #content>
            <SocialProfile />
          </template>
        </Card>

        <Card>
          <template #title>
            Update Password
          </template>
          <template #content>
            <UpdatePassword />
          </template>
        </Card>
      </div>

      <Card v-else>
        <template #title>
          Social Profile
        </template>
        <template #content>
          <SocialProfile />
        </template>
      </Card> -->

      <!-- Divider -->
      <!-- <div class="flex items-center">
        <div class="border-t flex-1 border-red-400"></div>
        <span class="px-4 font-medium text-red-400 whitespace-nowrap">Danger Zone</span>
        <div class="border-t flex-1 border-red-400"></div>
      </div> -->

      <!-- Danger Zone -->

      <!-- <div class="flex flex-col">
        <Card>
          <template #title>
            Account Deletion
          </template>
          <template #content>
          </template>
        </Card>
      </div> -->
    </div>


    <!-- Right Spacer -->
    <div class="hidden lg:flex flex-1"></div>
  </div>
</template>

<script setup>
import PersonalInfo from './PersonalInfo.vue';
import UpdatePassword from './UpdatePassword.vue';
import SocialProfile from './SocialProfile.vue';
import AccountDeletion from './AccountDeletion.vue';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();

</script>

<style scoped>
/* Add your styles here */
</style>