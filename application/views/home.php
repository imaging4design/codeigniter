<div id="app">

	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<h1>Welcome</h1>
				
				<button class="btn btn-warning" @click="showTopPerformers">Results</button>
				<ul>
					<li v-for="athlete in athletes">
						<strong>{{athlete.eventName}}</strong> {{athlete.nameFirst}} {{athlete.nameLast}} {{athlete.distHeight}} {{athlete.time}}
					</li>
				</ul>

				<button class="btn btn-warning" @click="showTopMultis">Show Multis</button>
				<ul>
					<li>
						{{multi.eventName}} {{multi.nameFirst}} {{multi.nameLast}} {{multi.points}}
					</li>
				</ul>

				<button class="btn btn-warning" @click="showTopRelays">Show Relays</button>
				<ul>
					<li v-for="relay in relays">
						{{relay.eventName}} {{relay.nameFirst}} {{relay.nameLast}} {{relay.distHeight}} {{relay.time}}
					</li>
				</ul>

			</div>
		</div>
	</div>
</div>