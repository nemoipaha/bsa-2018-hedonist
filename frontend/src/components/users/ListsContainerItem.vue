<template>
    <li class="column is-4">
        <div
            class="cities-cart"
            :style="{backgroundImage: 'url(' + userListImgUrl() + ')' }"
        >
            <div>
                <router-link :to="`/list/${userList.id}`">
                    <p><span class="cities-cart-name">{{ userList.name }}</span></p>
                </router-link>
                <p><span class="cities-cart-reviews">
                    {{ userList.places | countPlaces }}
                    {{ $t('other_user_page.lists_container.list.subtitle') }}
                </span></p>
            </div>
            <div class="cities-cart-see">
                <router-link :to="`/list/${userList.id}`" class="button is-info">
                    <span>{{ $t('other_user_page.lists_container.list.proceed') }}</span>
                </router-link>
            </div>
        </div>
    </li>
</template>

<script>
import {mapState, mapActions, mapGetters} from 'vuex';
export default {
    name: 'ListsContainer',
    data() {
        return {};
    },
    props: {
        userList: {
            required: true,
            type: Object,
        },
    },
    filters: {
        countPlaces: function (places) {
            return places.length;
        },
    },
    methods: {
        userListImgUrl() {
            return this.userList.img_url ? this.userList.img_url : '/assets/no-image-available.jpg';
        }
    }
};
</script>

<style lang="scss" scoped>
    .user-cities {
        padding: 20px 0;
        h3 {
            text-align: center;
        }

        .user-cities-items {
            li {

                .cities-cart {
                    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.28);
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    border-radius: 3px;
                    padding: 20px;
                    background-color: #fff;
                    height: 300px;
                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repeat;
                    cursor: pointer;
                    transition: 0.3s linear;

                    &:hover {
                        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.5);
                    }

                    &-name,
                    &-reviews {
                        display: inline-block;
                        padding: 0 10px;
                        background-color: rgba(146, 146, 146, 0.74);
                        color: #ffffff;
                    }

                    &-name {
                        font-size: 22px;
                        margin-bottom: 5px;
                        word-break: break-all;
                    }
                    &-reviews {
                        font-size: 16px;
                    }

                    &-see {
                        a {
                            display: block;
                        }

                    }
                }
            }
        }
    }
</style>