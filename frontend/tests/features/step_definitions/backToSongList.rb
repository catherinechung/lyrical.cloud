Then /^I see page (.*?)$/ do |path|
    current_url.should == path
end

Then /^I see (.*?)$/ do |path|
    current_url.should == path
end
