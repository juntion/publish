<template functional>
    <a-sub-menu
            :key="props.menuInfo.key"
    >
    <span slot="title">
        <a-icon :type="props.menuInfo.type" />
        <span>{{ JSON.parse(props.menuInfo.locale)[props.language] }}</span>
    </span>
        <template v-for="item in props.menuInfo.children" >
            <a-menu-item
                    v-if="!item.children"
                    :key="item.key"
            >
                <router-link :to="{ name: item.key }">{{ JSON.parse(item.locale)[props.language] }}</router-link>
            </a-menu-item>
            <SubMenu
                    v-else
                    :key="item.key"
                    :menu-info="item"
                    :language="props.language"
            />
        </template>
    </a-sub-menu>
</template>
<script>
import SubMenu from './SubMenu.vue'

export default {
  props: ['menuInfo', 'language'],
  components: { SubMenu }
}
</script>
