var fill = d3.scale.category20b();

var w = window.innerWidth,
    h = 500;

var max,
    fontSize;

var layout = d3.layout.cloud()
        .timeInterval(Infinity)
        .size([w, h])
        .fontSize(function(d) {
            return fontSize(+d.value);
        })
        .text(function(d) {
            return d.key;
        })
        .on("end", draw);

var svg = d3.select("#vis").append("svg")
        .attr("width", w)
        .attr("height", h);

var vis = svg.append("g").attr("transform", "translate(" + [w >> 1, h >> 1] + ")");

update();

window.onresize = function(event) {
    update();
};

function draw(data, bounds) {
    svg.remove();

    svg = d3.select("#vis").append("svg").attr("width", w).attr("height", h);

    vis = svg.append("g").attr("transform", "translate(" + [w >> 1, h >> 1] + ")");

    var w = window.innerWidth,
    h = 500;

    var origColor;

    svg.attr("width", w).attr("height", h);

    scale = bounds ? Math.min(
            w / Math.abs(bounds[1].x - w / 2),
            w / Math.abs(bounds[0].x - w / 2),
            h / Math.abs(bounds[1].y - h / 2),
            h / Math.abs(bounds[0].y - h / 2)) / 2 : 1;

    var text = vis.selectAll("text")
            .data(data, function(d) {
                return d.text.toLowerCase();
            });
    text.transition()
            .duration(1000)
            .attr("transform", function(d) {
                return "translate(" + [d.x, d.y] + ")";
            })
            .style("font-size", function(d) {
                return d.size + "px";
            });
    text.enter().append("text")
            .attr("text-anchor", "middle")
            .attr("transform", function(d) {
                return "translate(" + [d.x, d.y] + ")";
            })
            .style("font-size", function(d) {
                return d.size + "px";
            })
            .style("opacity", 1e-6)
            .transition()
            .duration(1000)
            .style("opacity", 1);
    text.on("click", datum => { 
        localStorage.setItem('word', datum["text"]);
        localStorage.setItem('searchState', YES_SEARCH);

        $.ajax({
            type: 'GET',
            url: 'http://localhost:8080/api/songlist/' + datum["text"],
            dataType: 'jsonp',
            success: function(data) {
                localStorage.setItem('songlist', JSON.stringify(data));
                window.location.href = "songList.html";
            },
            error: function(err) {
                console.log(err);
            }
        });
    });
    text.on("mouseover", function(d) {
        origColor = d3.select(this).style("fill");
        d3.select(this).style("fill", "#e8ea80");
    });
    text.on("mouseout", function(d) {
        d3.select(this).style("fill", origColor);
    });
    text.style("font-family", function(d) {
        return d.font;
    })
            .style("fill", function(d) {
                return fill(d.text.toLowerCase());
            })
            .text(function(d) {
                return d.text;
            });

    showPage();
    vis.transition().attr("transform", "translate(" + [w >> 1, h >> 1] + ")scale(" + scale + ")");
}

function showPage() {
    document.getElementById("loader").style.display = "none";
    $("#vis").show();
}

function update() {
    layout.font('impact').spiral('rectangular');
    fontSize = d3.scale['sqrt']().range([10, 100]);
    if (tags.length){
        fontSize.domain([+tags[tags.length - 1].value || 1, +tags[0].value]);
    }
    layout.stop().words(tags).start();
}
