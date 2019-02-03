<template>
	<div class="text-xs-center">
		<v-dialog
			v-model="dialog"
			width="500"
			>
			<v-btn
				slot="activator"
				color="red"
				dark
				>
				Click Me
			</v-btn>

			<v-card>
				<v-card-title
					class="headline grey lighten-2"
					primary-title
					>
					<slot name="header"></slot>
				</v-card-title>

				<v-card-text>
					<slot name="body"></slot>
				</v-card-text>

				<v-divider></v-divider>

				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn
						color="primary"
						flat
						@click="dialog = false"
						>
						I accept
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</div>
</template>


<script>
  export default {
    data () {
      return {
        dialog: false
      }
    }
  }
</script>