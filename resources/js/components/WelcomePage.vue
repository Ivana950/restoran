<template>
    <v-app>
        <v-row>
            <v-col>
                <div
                    class="welcomePage d-flex align-items-center justify-content-center"
                >
                    <div class="welcome">
                        <h1 class="display-2 black--text">
                            Dobrodošli u restoran Toscana!
                        </h1>
                    </div>
                </div>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <my-footer></my-footer>
            </v-col>
        </v-row>
    </v-app>
</template>
<style scoped>
.welcomePage {
    height: 500px;
    background-image: url("https://img.theculturetrip.com/650x/wp-content/uploads/2021/12/carlos-lindner-sjbya8daw54-unsplash.jpg");
    background-size: cover;
}
.welcome {
    background-color: white;
    border-radius: 8px;
    opacity: 0.78;
    padding: 10px;
}
</style>
