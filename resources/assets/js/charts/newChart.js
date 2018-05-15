
import { Doughnut } from 'vue-chartjs'

// import the component - chart you need


export default Doughnut.extend({
    props:['pro', 'against'],

    mounted () {
        // Overwriting base render method with actual data.
        this.renderChart({
            type: 'doughnut',

            labels: ['Za', 'Proti'],

            datasets: [
                {
                    label: 'Število glasov',
                    backgroundColor: ['#2ab27b', '#ef6733'],
                    data: [this.pro, this.against ],
                }
            ],
            options: {
                display: true,
                position: 'bottom',
                text: 'Custom Chart Title',
                rotation: 1 * Math.PI,
                circumference: 1 * Math.PI
            },
        },

        )
    }
})