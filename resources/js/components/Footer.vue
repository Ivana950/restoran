<template>
    <footer dark padless class="mt-16">
        <v-card flat tile class="blue-grey white--text text-center">
            <v-card-text>
                <v-btn
                    v-for="icon in icons"
                    :key="icon"
                    class="mx-4 white--text"
                    icon
                >
                    <v-icon size="24px">
                        {{ icon }}
                    </v-icon>
                </v-btn>
            </v-card-text>

            <v-card-text class="white--text pt-0 px-auto">
                <v-row>
                    <v-col>
                        <ul>
                            <li>RADNO VRIJEME</li>
                            <li>Pon - Pet</li>
                            <li>08:00 - 23:00</li>
                            <li>Sub -Ned</li>
                            <li>08:00 - 00:00</li>
                        </ul>
                    </v-col>
                    <v-col>
                        <ul>
                            <li>INFO</li>
                            <li>Kako do nas</li>
                            <li>Kontakt</li>
                        </ul>
                    </v-col>
                    <v-col>
                        <ul>
                            <li>KONTAKT</li>
                            <li>
                                XIV ulica br.97, 76270 Orašje, Bosna i
                                Hercegovina
                            </li>
                            <li>info@toscana.ba</li>
                            <li>+387 31 757 982</li>
                        </ul>
                    </v-col>
                </v-row>
            </v-card-text>

            <v-divider class="white"></v-divider>

            <v-card-text class="white--text">
                {{ new Date().getFullYear() }} — <strong>Toscana</strong>
            </v-card-text>
        </v-card>
    </footer>
</template>
<script>
export default {
    data: () => ({
        icons: ["mdi-facebook", "mdi-twitter", "mdi-linkedin", "mdi-instagram"],
    }),
};
</script>
<style scoped>
ul {
    list-style-type: none;
}
li {
    font-size: 1rem;
    padding-top: 12px;
}
</style>
