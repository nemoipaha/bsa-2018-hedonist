<template>
    <div class="notification-message">
        <span class="user">
            <span class="user__avatar-wrp">
                <img class="user__avatar" :src="getUserAvatar">
            </span>
            <router-link
                class="user__name"
                :to="{ name: 'OtherUserPage', params: { id: user.id } }"
            >
                {{ getUserName }}
            </router-link>
        </span>
        <span class="text">{{ $t('notifications.review_place.made_review') }} -&nbsp;</span>
        <span class="place-link">
            <router-link :to="`/places/${notification['id']}`">
                {{ getPlaceName }}
            </router-link>
        </span>
        <span class="date" v-if="createdAt">
            ({{ getDate }})
        </span>
    </div>
</template>

<script>
import notificationsMixin from '@/components/mixins/notifications';

export default {
    name: 'ReviewPlaceNotification',
    mixins: [notificationsMixin],
    computed: {
        getPlaceName() {
            return this.notification.localization[0]['place_name'];
        },
    }
};
</script>

<style lang="scss" scoped>
    @import '@/styles/notifications.scss';
</style>