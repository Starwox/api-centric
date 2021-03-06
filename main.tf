# Configure the Heroku provider
provider "heroku" {
  email   = "rezzoug.yannis@gmail.com"
  api_key = "a35b1a18-0ba6-48b3-8f1b-9decf046eea0"
}

terraform {
  required_providers {
    heroku = {
      source = "heroku/heroku"
      version = "4.2.0"
    }
  }
}

variable "deliveryrh" {
  description = "Name of the Heroku app provisioned as an example"
}

resource "heroku_app" "delivery" {
  name   = "deliveryrh"
  region = "eu"
}

# Build code & release to the app
resource "heroku_build" "delivery" {
  app        = heroku_app.delivery.name
  source {
    # This app uses a community buildpack, set it in `buildpacks` above.
    path     = "./"
  }
}

# Launch the app's web process by scaling-up
resource "heroku_formation" "delivery" {
  app        = heroku_app.delivery.name
  type       = "web"
  quantity   = 1
  size       = "Standard-1x"
  depends_on = [heroku_build.delivery]
}

output "example_app_url" {
  value = "https://${heroku_app.delivery.name}.herokuapp.com"
}